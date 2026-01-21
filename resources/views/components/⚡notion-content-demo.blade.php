<?php

use Livewire\Component;

new class extends Component
{
    public array $pages = [];
    public ?string $selectedPage = null;

    public string $content = '';

    public function mount()
    {
        $databaseId = '2a628ba3-235d-803c-8505-d00bacee4888';
        $collectionOfPages = Notion::database($databaseId)->query()->asCollection();

        $this->pages = $collectionOfPages->map( fn($p) => [
            'id' => $p->getId(),
            'title' => $p->getTitle(),
        ])->toArray();
    }

    public function updatedSelectedPage($value)
    {
        $page = Notion::pages()->find($value);

        $blocks = Notion::block($value)
            ->children()
            ->asCollection();

        $contentBlocks = $blocks->map(fn($b) => $b->getRawResponse())
            ->map( function($b) {
                return [
                    'type' => $type = $b['type'],
                    'text' => $this->notionRichTextToMarkdown($b[$type]['text']),
                ];

            });

        $content = $this->blocksToMarkdownText($contentBlocks->toArray());

        $content = Str::of(Str::markdown($content,['html_input' => 'strip']))->remove('\n', '\r');

        $replacements = [
            '<h1>' => '<h1 class="text-3xl font-bold mt-4 mb-1">',
            '<h2>' => '<h2 class="text-2xl font-semibold mt-2 mb-1">',
            '<p>'  => '<p class="text-gray-800">',
            '<ul>' => '<ul class="list-disc ml-4">',
            '<li><p>' => '<li>',
            '</p></li>' => '</li>',
            '<a ' => '<a class="text-purple-600 underline" ',
        ];

        foreach ($replacements as $search => $replace) {
            $content = str_replace($search, $replace, $content);
        }

        $this->content = $content;
    }

    private function notionRichTextToMarkdown(array $richText): string
    {
        $markdown = '';

        foreach ($richText as $segment) {
            $text = $segment['plain_text']
                ?? ($segment['text']['content'] ?? '');

            $annotations = $segment['annotations'] ?? [];

            $bold         = $annotations['bold']         ?? false;
            $italic       = $annotations['italic']       ?? false;
            $strike       = $annotations['strikethrough']?? false;
            $underline    = $annotations['underline']    ?? false;
            $code         = $annotations['code']         ?? false;

            $linkUrl = null;
            if (!empty($segment['href'])) {
                $linkUrl = $segment['href'];
            } elseif (!empty($segment['text']['link']['url'] ?? null)) {
                $linkUrl = $segment['text']['link']['url'];
            }

            $prefix = '';
            $suffix = '';

            // order matters to keep nesting stable
            if ($code) {
                $prefix .= '`';
                $suffix = '`' . $suffix;
            }

            if ($bold) {
                $prefix .= '**';
                $suffix = '**' . $suffix;
            }

            if ($italic) {
                $prefix .= '*';
                $suffix = '*' . $suffix;
            }

            if ($strike) {
                $prefix .= '~~';
                $suffix = '~~' . $suffix;
            }

            if ($underline) {
                // markdown has no native underline
                $prefix .= '<u>';
                $suffix = '</u>' . $suffix;
            }

            $formatted = $prefix . $text . $suffix;

            if ($linkUrl) {
                $formatted = '[' . $formatted . '](' . $linkUrl . ')';
            }

            $markdown .= $formatted;
        }

        return $markdown;
    }


    private function blocksToMarkdownText(array $blocks): string {
        return collect($blocks)
            ->map(function (array $block): ?string {
                $type = $block['type'] ?? null;
                $text = (string) ($block['text'] ?? '');

                return match ($type) {
                    'heading_1' => '# ' . $text,
                    'heading_2' => '## ' . $text,
                    'paragraph' => trim($text) === '' ? '' : $text,
                    'bulleted_list_item' => '- ' . $text,
                    'callout' => '> ' . $text,
                    default => null,
                };
            })
            ->filter(fn ($line) => $line !== null)
            ->implode("\n\n");
    }

};
?>

<div>
    <div class="grid grid-cols-3 gap-4">
        @foreach($pages as $page)
            <div wire:click="$set('selectedPage', '{{$page['id']}}')" class="p-4 border border-purple-500 hover:bg-purple-500 hover:text-white group cursor-pointer">
                <div class="text-gray-500 group-hover:text-purple-100 text-xs">{{$page['id']}}</div>
                <div class="text-lg font-semibold">{{$page['title']}}</div>
            </div>
        @endforeach
    </div>

    <div class="mt-8 p-4 border border-gray-300 bg-gray-50">
        {!! $content !!}
    </div>
</div>
