
{{-- <pre>{{ print_r($companies, true) }}</pre> --}}
{{-- list content --}}
@if (isset($companies))
    @extends('layouts.app')
    @section('content')
        <div class="container page-content" data-url="{{url('/')}}/company/modal">
            <div class="d-flex align-items-center justify-content-between options">
            <h1 class="my-5 h3">Εταιρείες</h1>
            <a href="javascript:void(0)" class="text-decoration-none tooltip-top" data-action="add" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-title="Προσθήκη">
                @include('components.svg', ['name' => 'plus-square'])
            </a>
            </div>
            @if (!$companies->isEmpty())
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Ονομασία</th>
                        <th scope="col">Email</th>
                        <th scope="col">Ιστοσελίδα</th>
                        <th scope="col">Επεξεργασία</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($companies as $company)                  
                        <tr>
                            <th scope="row">{{$company->id}}</th>
                            <td>{{$company->name}}</td>
                            <td>{{$company->email}}</td>
                            <td>{{$company->website}}</td>
                            <td>
                                <div class="options d-flex justify-content-between">
                                <a href="javascript:void(0)" class="text-decoration-none tooltip-top" data-action="preview" data-id="{{$company->id}}" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-title="Προβολή">
                                    @include('components.svg', ['name' => 'box-arrow-up-right'])
                                </a>
                                <a href="javascript:void(0)" class="text-decoration-none tooltip-top" data-action="edit" data-id="{{$company->id}}" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-title="Επεξεργασία">
                                    @include('components.svg', ['name' => 'pencil-square'])
                                </a>
                                <a href="javascript:void(0)" class="text-decoration-none tooltip-top" data-action="delete" data-id="{{$company->id}}" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-title="Διαγραφή">
                                    @include('components.svg', ['name' => 'trash3-fil'])
                                </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $companies->links() }} <!-- Display pagination links -->
            @else
                <p> Δεν υπάρχουν εγραφές</p>
                <p> Αν δεν έχουν δημιουργηθεί κατηγορίες δεν θα δημιουργηθούν οι αντίστοιχες εγραφές ανά εταιρεία.</p>
                <form action="{{ route('company.random') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="number_of_companies" class="form-label">Number of Companies - max 100</label>
                        <input type="number" class="form-control" id="number_of_companies" name="number_of_companies" min="1" max="100" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Generate Random Companies</button>
                </form>                
            @endif
            <!-- Pagination links -->
        </div>
    @endsection

{{-- modal content --}}
@elseif (isset($action))
{{-- <pre>{{ print_r($categories, true) }}</pre> --}}
    @php
        $disableInput = NULL;
        $formAction = route('company.list');
        switch ($action) {
            case 'add':
                $title = 'Προσθήκη εταιρείας';
                $formAction = route('company.add');
                break;
            case 'preview':
                $title = 'Προβολή εταιρείας';
                $disableInput = 'disabled';
                break;
            case 'edit':
                $title = 'Τροποποίηση εταιρείας';
                $formAction = route('company.update', $company->id);
                break;
            case 'delete':
                $title = 'Διαγραφή εταιρείας';
                $disableInput = 'disabled';
                $formAction = route('company.delete', $company->id);
                break;
            default:
                $title = 'Modal title';
                break;
        }
    @endphp

    @section('inputs')
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="company-name" name="name" {{$disableInput}} value="{{$company->name??NULL}}">
            <label for="company-name">Ονομασία</label>
        </div>
        @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="form-floating mb-3">
            <select class="select-picker form-control" id="company-categories" name="categories[]" {{$disableInput}} multiple title="Χωρίς επιλογή">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $company&&$company->categories->contains($category->id) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <label for="company-categories">Κατηγορίες</label>
        </div>
          
        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="company-email" name="email" {{$disableInput}} value="{{$company->email??NULL}}">
            <label for="company-email">Email address</label>
        </div>
        <div class="form-floating mb-3">
            <textarea class="form-control h-100" id="company-description" name="description" rows="3" {{$disableInput}}>{{$company->description??NULL}}</textarea>
            <label for="company-description">Περιγραφή δραστηριότητας</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="company-website" name="website" {{$disableInput}} value="{{$company->website??NULL}}">
            <label for="company-website">Ιστοσελίδα</label>
        </div>
        <div class="form-floating mb-3" id="logo-input-container">
            <input type="file" class="form-control form-control-file" id="company-logo" name="logo" {{$disableInput}}>
            <label class="" for="company-logo">Λογότυπο</label>
            <span id="logoFileName" style="margin-top: 5px; display: none; font-size: 14px;"></span>
        </div>
            <div id="logo-preview">
                <img src="{{ isset($company->logo)?asset('storage/' . $company->logo):'#' }}" alt="Company Logo" style="max-width: 100px;">
                @if (!$disableInput)
                    <button type="button" class="btn btn-sm border-danger-subtle bg-danger-subtle mx-2" id="deleteLogoBtn">Διαγραφή</button>
                @endif
            </div>

    @endsection

    @section('form')
        <form id="company-form" data-action="{{$action}}" method="POST" action="{{$formAction}}" enctype="multipart/form-data">
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
                    <button type="button" class="btn border-secondary-subtle bg-secondary-subtle" data-bs-dismiss="modal">Ακύρωση</button>
                    <button type="submit" class="btn border-primary-subtle bg-primary-subtle">Αποθήκευση</button>
                </div>
            @endif
            @if ($action == 'delete')
                <div class="modal-footer d-flex flex-column">
                    <p class="mb-2">Να γίνει οριστική διαγραφή;</p>
                    <div>
                        <button type="button" class="btn border-secondary-subtle bg-secondary-subtle" data-bs-dismiss="modal">Ακύρωση</button>
                        <button type="submit" class="btn border-danger-subtle bg-danger-subtle">Διαγραφή</button>
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



