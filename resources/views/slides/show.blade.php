@extends('layouts.app')

@section('content')
<div class="container text-center">
    @php
    $slides = ['materi1'];
    $currentKey = array_search(pathinfo($filename, PATHINFO_FILENAME), $slides);
    @endphp

    <div class="d-flex justify-content-end mb-3">
        @if($prev)
        <a href="{{ url('/slides/' . $prev) }}" class="btn btn-primary me-2">Kembali</a>
        @endif

        @if($next)
        <a href="{{ url('pembelajaran/video2') }}" class="btn btn-primary me-2">Back</a>
        <a href="{{ url('/slides/' . $next) }}" class="btn btn-primary">Next</a>
        @else
        <form action="{{ route('slides.selesai') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-success">Selesai</button>
        </form>

        @endif
    </div>

    <h2 class="mb-4">Materi Pencemaran Udara</h2>


    <div id="pdf-container" class="flex justify-center items-center">
        <canvas id="pdf-render"></canvas>
    </div>

    <div class="mt-4">
        <button onclick="prevPage()" class="btn btn-primary">Previous</button>
        <span>Page: <span id="page-num"></span> / <span id="page-count"></span></span>
        <button onclick="nextPage()" class="btn btn-primary">Next</button>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>

<script>
    const url = "{{ asset('slides/' . $filename) }}";

    let pdfDoc = null,
        pageNum = 1,
        pageIsRendering = false,
        pageNumIsPending = null;

    const scale = 1.5,
        canvas = document.querySelector('#pdf-render'),
        ctx = canvas.getContext('2d');

    const renderPage = num => {
        pageIsRendering = true;

        pdfDoc.getPage(num).then(page => {
            const viewport = page.getViewport({
                scale
            });
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            const renderCtx = {
                canvasContext: ctx,
                viewport
            };

            return page.render(renderCtx).promise;
        }).then(() => {
            pageIsRendering = false;

            if (pageNumIsPending !== null) {
                renderPage(pageNumIsPending);
                pageNumIsPending = null;
            }
        });

        document.querySelector('#page-num').textContent = num;
    };

    const queueRenderPage = num => {
        if (pageIsRendering) {
            pageNumIsPending = num;
        } else {
            renderPage(num);
        }
    };

    const prevPage = () => {
        if (pageNum <= 1) return;
        pageNum--;
        queueRenderPage(pageNum);
    };

    const nextPage = () => {
        if (pageNum >= pdfDoc.numPages) return;
        pageNum++;
        queueRenderPage(pageNum);
    };

    pdfjsLib.getDocument(url).promise.then(pdfDoc_ => {
        pdfDoc = pdfDoc_;
        document.querySelector('#page-count').textContent = pdfDoc.numPages;
        renderPage(pageNum);
    });
</script>
@endsection