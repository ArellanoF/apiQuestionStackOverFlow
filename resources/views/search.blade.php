<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Stack Overflow</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">
            <img src="https://www.factorenergia.com/wp-content/themes/factorenergia/assets/img/logo-factorenergia-lupa.png" width="140" height="50" class="d-inline-block align-top" alt="">
        </a>
    </nav>
    <div class="container mt-5 container-form">
        <h1 class="mb-4">Search Stack Overflow</h1>
        <form id="searchForm" action="/search/results" method="GET">
            <div class="form-group">
                <label for="tagged">Tagged:</label>
                <input type="text" id="tagged" name="tagged" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="fromDate">From Date:</label>
                <input type="date" id="fromDate" name="fromDate" class="form-control">
            </div>
            <div class="form-group">
                <label for="toDate">To Date:</label>
                <input type="date" id="toDate" name="toDate" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>
    <div class="container mt-5">
        @if (isset($result))
            @if (isset($result['items']) && count($result['items']) > 0)
                <div class="accordion" id="resultsAccordion">
                    <div class="card">
                        <div class="card-header" id="headingResults">
                            <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseResults" aria-expanded="true" aria-controls="collapseResults">
                                    {{ count($result['items']) }} Results
                                </button>
                            </h2>
                        </div>

                        <div id="collapseResults" class="collapse none" aria-labelledby="headingResults" data-parent="#resultsAccordion">
                            <div class="card-body">
                                <ul class="list-group">
                                    @foreach ($result['items'] as $index => $item)
                                        <li class="list-group-item {{ $index % 2 == 0 ? 'bg-light' : 'bg-white' }}">
                                            <img style="width: 30px;height: 30px;" src="https://proyectosbeta.net/wp-content/uploads/2016/10/Logo-StackOverFlow.png">
                                            <a href="{{ $item['link'] }}">{{ $item['title'] }}</a>
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
    </div>
    
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
