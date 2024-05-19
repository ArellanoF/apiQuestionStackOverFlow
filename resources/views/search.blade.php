<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Stack Overflow</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="https://www.factorenergia.com/wp-content/uploads/2016/05/cropped-favicon512-32x32.png" sizes="32x32" />
</head>
@php
    use Carbon\Carbon;
@endphp
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="https://www.factorenergia.com/es/" target="_blank">
            <img src="https://www.factorenergia.com/wp-content/themes/factorenergia/assets/img/logo-factorenergia-lupa.png" width="140" height="50" class="d-inline-block align-top" alt="">
        </a>
        <div class="ml-auto">
            <a href="/"><button class="btn mr-3" style="background-color: #262699;
                color: white;">Home</button></a>
        </div>
    </nav>
    <div class="container mt-5 container-form">
        <h2 class="mb-4">Search question Stack Overflow</h2>
        <form id="searchForm" action="/search/results" method="GET">
            <div class="form-group">
                <label for="tagged">Tagged:</label>
                <input type="text" id="tagged" name="tagged" class="form-control" required value="{{ isset($_GET['tagged']) ? $_GET['tagged'] : '' }}">
                <span id="tagged-info">**Use the tagged parameter with a semi-colon delimited list of tags. This is an and constraint, passing tagged=c;java will return only those questions with both tags. As such, passing more than 5 tags will always return zero results.</span>
            </div>
            <div class="row">
                <div class="form-group col-sm-6">
                    <label for="fromDate">From:</label>
                    <input type="date" id="fromDate" name="fromDate" class="form-control" value="{{ isset($_GET['fromDate']) ? $_GET['fromDate'] : '' }}">
                </div>
                <div class="form-group col-sm-6">
                    <label for="toDate">To:</label>
                    <input type="date" id="toDate" name="toDate" class="form-control" value="{{ isset($_GET['toDate']) ? $_GET['toDate'] : '' }}">
                </div>
                </div>
                <div class="row justify-content-center">
                    <button type="submit" class="btn btn-info">Search</button>
                </div>
        </form>
    </div>
    <div class="container mt-5">
        @if (isset($result))
            @if (isset($result['items']) && count($result['items']) > 0)
                <div class="accordion mb-5" id="resultsAccordion">
                    <div class="card">
                        <div class="card-header" id="headingResults">
                            <h2 class="mb-0">
                                <div class="row">
                                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseResults" aria-expanded="true" aria-controls="collapseResults">
                                        Total results: {{ count($result['items']) }} <span id="tagged-info">(max:100)</span>    
                                        <i id="collapseIcon" class="fas fa-chevron-down float-right mt-1"></i>                               
                                </button>
                            </div>
                            </h2>
                        </div>

                        <div id="collapseResults" class="collapse hide" aria-labelledby="headingResults" data-parent="#resultsAccordion">
                            <div class="card-body">
                                <ul class="list-group">
                                    @foreach ($result['items'] as $index => $item)
                                    @php
                                        // Convertir el timestamp Unix a una fecha legible usando Carbon
                                        $creation = Carbon::createFromTimestamp($item['creation_date'])->format('d F Y H:i:s');
                                        $modified = Carbon::createFromTimestamp($item['last_activity_date'])->format('d F Y H:i:s');
                                    @endphp
                                        <li class="list-group-item {{ $index % 2 == 0 ? 'bg-light' : 'bg-white' }}">
                                            <img style="width: 30px;height: 30px;" src="https://proyectosbeta.net/wp-content/uploads/2016/10/Logo-StackOverFlow.png">
                                            <a href="{{ $item['link'] }}" target="_blank">- {{ $item['title'] }}</a><br>
                                            @foreach ($item['tags'] as $tag)
                                            <span class="badge bg-info mb-2 mt-2"><a href="https://stackoverflow.com/questions/tagged/{{$tag}}" target="_blank">{{$tag}}</a></span>
                                            @endforeach
                                            <br>
                                            <span id="extra-info"> Creation:</span><span id="extra-info-question">{{$creation}}</span>
                                            <span id="extra-info"> Modified:</span><span id="extra-info-question">{{$modified}}</span>
                                            <span id="extra-info">  Score: </span><span id="extra-info-question">{{$item['score']}}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-warning mt-4" role="alert">
                    No questions found.
                </div>
            @endif
        @endif
        @if (isset($error))
        <div class="alert alert-warning mt-4" role="alert">
            API error
        </div>
        @endif
    </div>
        <!-- Footer -->
        <footer class="bg-light text-center text-lg-start mt-5 fixed-footer">            
            <div class="text-center p-3 text-white" style="background-color:#262699">
                Francesc Arellano Cachopo -- francescarellano@gmail.com
            </div>
        </footer>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
<script>
    $('#collapseResults').on('shown.bs.collapse', function () {
        $('#collapseIcon').removeClass('fa-chevron-down').addClass('fa-chevron-up');
    });

    $('#collapseResults').on('hidden.bs.collapse', function () {
        $('#collapseIcon').removeClass('fa-chevron-up').addClass('fa-chevron-down');
    });
</script>

</html>
