
{{-- <pre>{{ print_r($companies, true) }}</pre> --}}
{{-- list content --}}
@if (isset($categories))
    @extends('layouts.app')
    @section('content')
        <div class="container page-content" data-url="{{url('/')}}/category/modal">
            <div class="d-flex align-items-center justify-content-between options">
            <h1 class="my-5 h3">Κατηγορίες</h1>
            <a href="javascript:void(0)" class="text-decoration-none" data-action="add" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <img src="{{ asset('icons/plus.svg') }}" alt="Edit Icon">
            </a>
            </div>
            @if(!$categories->isEmpty())
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Όνομα</th>
                        <th scope="col">Περιγραφή</th>
                        <th scope="col">Επεξεργασία</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)                  
                        <tr>
                            <th scope="row">{{$category->id}}</th>
                            <td>{{$category->name}}</td>
                            <td>{{$category->description}}</td>
                            <td>
                                <div class="options d-flex justify-content-between">
                                <a href="javascript:void(0)" class="text-decoration-none" data-action="preview" data-id="{{$category->id}}" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    <img src="{{ asset('icons/preview.svg') }}" alt="Show Icon">
                                </a>
                                <a href="javascript:void(0)" class="text-decoration-none" data-action="edit" data-id="{{$category->id}}" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    <img src="{{ asset('icons/pencil.svg') }}" alt="Edit Icon">
                                </a>
                                <a href="javascript:void(0)" class="text-decoration-none" data-action="delete" data-id="{{$category->id}}" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    <img src="{{ asset('icons/trash.svg') }}" alt="Delete Icon">
                                </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $categories->links() }} <!-- Display pagination links -->
            @else
                <p> Δεν υπάρχουν εγραφές</p>
                <form action="{{ route('category.random') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="number_of_categories" class="form-label">Number of Categories - max 10</label>
                        <input type="number" class="form-control" id="number_of_categories" name="number_of_categories" min="1" max="10" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Generate Random Categories</button>
                </form>
                
            @endif
        </div>
    @endsection

{{-- modal content --}}
@elseif (isset($action))
    @php
        $disableInput = '';
        $formAction = route('category.list');
        switch ($action) {
            case 'add':
                $title = 'Προσθήκη κατηγορίας';
                $formAction = route('category.add');
                break;
            case 'preview':
                $title = 'Προβολή κατηγορίας';
                $disableInput = 'disabled';
                break;
            case 'edit':
                $title = 'Τροποποίηση κατηγορίας';
                $formAction = route('category.update', $category->id);
                break;
            case 'delete':
                $title = 'Διαγραφή κατηγορίας';
                $disableInput = 'disabled';
                $formAction = route('category.delete', $category->id);
                break;
            default:
                $title = 'Modal title';
                break;
        }
    @endphp

    @section('inputs')
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="category-name" name="name" {{$disableInput}} value="{{$category->name??NULL}}">
            <label for="category-name">Όνομα</label>
        </div>
        @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="form-floating mb-3">
            <textarea class="form-control h-100" id="category-description" name="description" rows="3" {{$disableInput}}>{{$category->description??NULL}}</textarea>
            <label for="company-description">Περιγραφή</label>
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



