<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div x-data="{ replacing: false }" class="space-y-2">
        @php
            // Ambil data dari model berdasarkan UUID yang diberikan
            $record = \App\Models\ExampleOutcomingMail::where('uuid', $getState())->first();
            $fileExists = $record && !empty($record->file);
        @endphp

        @if ($fileExists)
            <template x-if="!replacing">
                <div class="flex items-center justify-between">
                    <a href="{{ route('example-outcoming-mails.preview', $getState()) }}"
                       target="_blank"
                       class="text-primary-600 underline">
                        Download File
                    </a>
                </div>
            </template>
        @else
            <div>
                None.
            </div>
        @endif
    </div>
</x-dynamic-component>
