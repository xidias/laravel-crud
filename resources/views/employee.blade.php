
{{-- <pre>{{ print_r($employees, true) }}</pre> --}}
{{-- list content --}}
@if (isset($employees))
    @extends('layouts.app')
    @section('content')
        <div class="container page-content" data-url="{{url('/')}}/employee/modal">
            <div class="d-flex align-items-center justify-content-between options">
            <h1 class="my-5 h3">Εργαζόμενοι</h1>
            <a href="javascript:void(0)" class="text-decoration-none" data-action="add" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <img src="{{ asset('icons/plus.svg') }}" alt="Edit Icon">
            </a>
            </div>
            @if(!$employees->isEmpty())
                <table class="table">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Ονοματεπώνυμο</th>
                    <th scope="col">Email</th>
                    <th scope="col">Tηλέφωνο</th>
                    <th scope="col">Επεξεργασία</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)                  
                    <tr>
                        <th scope="row">{{$employee->id}}</th>
                        <td>{{$employee->full_name}}</td>
                        <td>{{$employee->email}}</td>
                        <td>{{$employee->phone}}</td>
                        <td>
                            <div class="options d-flex justify-content-between">
                            <a href="javascript:void(0)" class="text-decoration-none" data-action="preview" data-id="{{$employee->id}}" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <img src="{{ asset('icons/preview.svg') }}" alt="Show Icon">
                            </a>
                            <a href="javascript:void(0)" class="text-decoration-none" data-action="edit" data-id="{{$employee->id}}" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <img src="{{ asset('icons/pencil.svg') }}" alt="Edit Icon">
                            </a>
                            <a href="javascript:void(0)" class="text-decoration-none" data-action="delete" data-id="{{$employee->id}}" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <img src="{{ asset('icons/trash.svg') }}" alt="Delete Icon">
                            </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                </table>
                {{ $employees->links() }} <!-- Display pagination links -->
            @else
                <p> Δεν υπάρχουν εγραφές</p>
                <form action="{{ route('employee.random') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="number_of_records" class="form-label">Number of Records</label>
                        <input type="number" class="form-control" id="number_of_records" name="number_of_records" min="1" max="100" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Generate Random Data</button>
                </form>
                
            @endif
        </div>
    @endsection

{{-- modal content --}}
@elseif (isset($action))
    @php
        $disableInput = '';
        $formAction = route('employee.list');
        switch ($action) {
            case 'add':
                $title = 'Προσθήκη εργαζόμενου';
                $formAction = route('employee.add');
                break;
            case 'preview':
                $title = 'Προβολή εργαζόμενου';
                $disableInput = 'disabled';
                break;
            case 'edit':
                $title = 'Τροποποίηση εργαζόμενου';
                $formAction = route('employee.update', $employee->id);
                break;
            case 'delete':
                $title = 'Διαγραφή εργαζόμενου';
                $disableInput = 'disabled';
                $formAction = route('employee.delete', $employee->id);
                break;
            default:
                $title = 'Modal title';
                break;
        }
    @endphp

    @section('inputs')
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="employee-name" name="full_name" {{$disableInput}} value="{{$employee->full_name??NULL}}">
            <label for="employee-name">Ονομασία</label>
        </div>
        @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="employee-email" name="email" {{$disableInput}} value="{{$employee->email??NULL}}">
            <label for="employee-email">Email address</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="employee-website" name="phone" {{$disableInput}} value="{{$employee->phone??NULL}}">
            <label for="employee-website">Tηλέφωνο</label>
        </div>
    @endsection

    @section('form')
        <form data-action="{{$action}}" method="POST" action="{{$formAction}}">
            @csrf
            @if ($action == 'edit')
                @method('PUT')
            @endif
            @if ($action == 'delete')
                @method('DELETE')
            @endif
            <div class="modal-body">
                @yield('inputs')
            </div>
            @if ($action == 'add'||$action == 'edit')
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ακύρωση</button>
                    <button type="submit" class="btn btn-primary">Αποθήκευση</button>
                </div>
            @endif
            @if ($action == 'delete')
                <div class="modal-footer d-flex flex-column">
                    <p class="mb-2">Να γίνει οριστική διαγραφή;</p>
                    <div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ακύρωση</button>
                        <button type="submit" class="btn btn-danger">Διαγραφή</button>
                    </div>
                </div>
            @endif
        </form>
    @endsection

    <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">{{$title}}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    @if ($action == 'preview')
        <div class="modal-body">
            @yield('inputs')
        </div>
    @else
        @yield('form')
    @endif
    @php
        exit;
    @endphp
<!-- Default content or error message -->
@else
    <p>No data available</p>
@endif



