<x-app-layout>

    <br>
    <br>
    <br>
    <br>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

           

            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header border-0">
                            <h3 class="mb-0">Pengguna yang ngebooking</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">name</th>
                                        <th scope="col">email</th>
                                    
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($bk as $item)
                               
                                        <tr>
                                            <td>{{ App\Models\User::where('id',$item->user_id)->pluck('name')->first()}}</td>
                                            <td>{{ App\Models\User::where('id',$item->user_id)->pluck('email')->first()}}</td>

                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                       
                    </div>
                </div>
            </div>
            <!-- Dark table -->



        </div>
    </div>
</x-app-layout>
