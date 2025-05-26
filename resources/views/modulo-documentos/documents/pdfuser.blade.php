@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">{{ $document->name }}</h4>
    <div id="pdf-viewer"></div>

    
</div>


@endsection




@push('js')
<script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>

<script>
    const url = '{{ asset("storage/" . $document->file_path_pdf) }}';

    const url = '{{ route("verpdf", ["id" => $document->id]) }}';


    const pdfjsLib = window['pdfjs-dist/build/pdf'];
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://mozilla.github.io/pdf.js/build/pdf.worker.js';

    pdfjsLib.getDocument(url).promise.then(function(pdf) {
        for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
            pdf.getPage(pageNum).then(function(page) {
                const scale = 1.2;
                const viewport = page.getViewport({ scale });

                const canvas = document.createElement("canvas");
                const context = canvas.getContext("2d");
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                document.getElementById("pdf-viewer").appendChild(canvas);

                const renderContext = {
                    canvasContext: context,
                    viewport: viewport
                };
                page.render(renderContext);
            });
        }
    });
</script>
@endpush
