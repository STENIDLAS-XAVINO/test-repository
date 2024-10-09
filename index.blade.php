<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{asset('images/logo_SIOKA.png')}}">
    <title>{{env('APP_NAME')}}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head> 

<body>
    <div class="container">
        {{-- header --}}
        <x-header></x-header>

        <div class="content">
            <h2>Tableau de diffusion hebdomadaire</h2>
            <div class="table_design">
                <table>
                    <thead>
                        <tr>
                            <th>Emission</th>
                            <th>Lundi</th> 
                            <th>Mardi</th>
                            <th>Mercredi</th>
                            <th>Jeudi</th>
                            <th>Vendredi</th>
                            <th>Samedi</th>
                            <th>Dimanche</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($schedules as $schedule)
                        <tr data-id="{{ $schedule->id }}">
                            <td class="emission" contenteditable="true">{{ $schedule->emission }}</td>
                            <td contenteditable="true">{{ $schedule->lundi }}</td>
                            <td contenteditable="true">{{ $schedule->mardi }}</td>
                            <td contenteditable="true">{{ $schedule->mercredi }}</td>
                            <td contenteditable="true">{{ $schedule->jeudi }}</td>
                            <td contenteditable="true">{{ $schedule->vendredi }}</td>
                            <td contenteditable="true">{{ $schedule->samedi }}</td>
                            <td contenteditable="true">{{ $schedule->dimanche }}</td>
                            <td><button class="save-btn"><i class="fa fa-save"></i></button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
            </div>
            <div id="message" style="display:none; padding: 10px; margin: 10px; border: 1px solid green; background-color: #e0ffe0; color: green;">
                Mise à jour réussie
            </div>
        </div>

        {{-- footer --}}
        <x-footer></x-footer>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.save-btn').on('click', function () {
                var row = $(this).closest('tr');
                var id = row.data('id'); // Assurez-vous que chaque ligne a un attribut data-id
                var emission = row.find('.emission').text();
                var lundi = row.find('td').eq(1).text();
                var mardi = row.find('td').eq(2).text();
                var mercredi = row.find('td').eq(3).text();
                var jeudi = row.find('td').eq(4).text();
                var vendredi = row.find('td').eq(5).text();
                var samedi = row.find('td').eq(6).text();
                var dimanche = row.find('td').eq(7).text();

                $.ajax({
                    url: '{{ route("update.schedule") }}',
                    method: 'POST',
                    data: {
                        id: id,
                        emission: emission,
                        lundi: lundi,
                        mardi: mardi,
                        mercredi: mercredi,
                        jeudi: jeudi,
                        vendredi: vendredi,
                        samedi: samedi,
                        dimanche: dimanche,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        toastr.success('Mise à jour réussie');
                    },
                    error: function () {
                        toastr.error('Erreur lors de la mise à jour');
                    }
                });
            });
        });
    </script>


</body>
</html>
