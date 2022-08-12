@extends('layouts.default', [])
@push('css')
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet" />
@endpush
@section('content')
    <div class="flex justify-between items-center relative">
        <h3 class="text-xl md:text-2xl">{{__('setting.manage_user')}}</h3>
        <div class="form-control">
            <form action="?" class="">
                <div class="input-group hidden md:inline-flex">
                    <input type="text" name="q" value="{{request('q') }}" placeholder="Search…" class="input input-bordered" />
                    <button class="btn btn-square">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </button>
                </div>
                {{-- <div class="md:hidden flex">
                    <input type="text" name="q" value="{{request('q') }}" class="w-16 hover:w-full py-1 rounded-l border border-gray-300" placeholder="{{__('general.search')}}...">
                    <button class="py-1 bg-primary px-2 rounded-r flex items-center text-white font-bold">
                        <ion-icon size="small" name="search-outline"></ion-icon>
                    </button>
                </div> --}}
            </form>
        </div>
    </div>

    @if (request('q'))
    <div class="pt-2 flex items-center gap-2">
        <small class="text-sm">{{__('general.search_for')}} : {{request('q')}}</small>
        <a href="?" class="text-red-600"><i class="fa-solid fa-times"></i></a>
    </div>
    @endif

    <label for="addUser" class="fixed bottom-10 z-50 right-4 md:right-10 bg-primary w-12 h-12 md:w-16 md:h-16 cursor-pointer hover:bg-secondary rounded-full text-white flex justify-center items-center text-4xl">
        <ion-icon  name="add-outline"></ion-icon>
    </label>

    <div class="mt-4 bg-white shadow-lg rounded mb-28 md:mb-16">
        <table class="table-fixed w-full">
            <thead class="bg-primary text-white hidden md:table-header-group">
                <th class="py-2 hidden md:table-cell" style="width: 10%">#</th>
                <th class="py-2 text-left" style="width: 25%">{{__('setting.username')}}</th>
                <th class="py-2 text-left hidden md:table-cell">{{__('Email')}}</th>
                <th class="py-2 text-left hidden md:table-cell">{{__('setting.user_language')}}</th>
                <th class="py-2 text-left hidden md:table-cell">{{__('setting.user_timezone')}}</th>
                {{-- <th class="py-2">Created at</th> --}}
                <th class="py-2">{{__('general.option')}}</th>
            </thead>
            <tbody>
                @forelse ($users as $item)
                <tr class="border">
                    <td class="py-2 text-center hidden md:table-cell">{{ $loop->iteration }}</td>
                    <td class="py-2 px-2">{{ $item->name }}</td>
                    <td class="py-2 hidden md:table-cell">{{ $item->email }}</td>
                    <td class="py-2 hidden md:table-cell">{{ $item->language }}</td>
                    <td class="py-2 hidden md:table-cell">{{ $item->timezone }}</td>
                    <td class="py-2 text-center px-2">
                        @if($item->id != auth()->user()->id)
                        <div class="flex gap-4 justify-center">
                            <form action="{{ route('setting.user.destroy',$item->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <div class="tooltip" data-tip="{{__('general.delete')}}">
                                    <button onclick="return confirm(`{{__('general.delete_confirm')}}`);" type="submit" class="text text-red-600"><i class="fa-solid fa-trash"></i></button>
                                </div>
                            </form>
                            <div class="tooltip" data-tip="{{__('general.edit')}}">
                                <label 
                                    for="editUser" 
                                    class="text-yellow-500 cursor-pointer"
                                    data-id="{{$item->id}}"
                                    data-action="{{route('setting.user.update',$item->id)}}"
                                    data-name="{{$item->name}}"
                                    data-email="{{$item->email}}"
                                    data-language="{{$item->language}}"
                                    data-timezone="{{$item->timezone}}"
                                    onclick="setEditForm(this)"
                                >
                                    <i class="fa-solid fa-pencil"></i>
                                </label>
                            </div>
                            <div class="tooltip" data-tip="{{__('general.reset_password')}}">
                                <label for="resetPass" onclick="setResetPass(this)" data-action="{{route('setting.user.update-pass',$item->id)}}" class="text-green-600 cursor-pointer"><i class="fa-solid fa-key"></i></label>
                            </div>
                        </div>
                        @else
                        <span class="bg-yellow-50 text-xs uppercase text-yellow-600">protected</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">{{__('general.data_not_found')}}</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="py-2 px-4">
            {{ $users->links() }}
        </div>
    </div>


    <!-- Put this part before </body> tag -->
    <input type="checkbox" id="addUser" class="modal-toggle" @if($errors->any()) checked @endif  />
    <div class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-2xl">{{__('setting.add_user')}}</h3>
            <form action="" method="POST" id="createUser">
            @csrf
            <div class="mt-3 mb-4">
                <div class="form-control mb-2">
                    <label for="" class="text-sm">{{__('setting.username')}}</label>
                    <input name="name" type="text" value="{{old('name')}}" class="w-full rounded py-2 border border-gray-400 @error('name') border-red-600 @enderror" required>
                </div>

                <div class="form-control mb-2">
                    <label for="" class="text-sm">{{__('setting.user_email')}}</label>
                    <input name="email" type="text" value="{{old('email')}}"  class="w-full rounded py-2 border border-gray-400 @error('email') border-red-600 @enderror" required>
                    @error('email')<small class="text-xs text-red-600">{{$message}}</small>@enderror
                </div>

                <div class="form-control mb-2">
                    <label for="" class="text-sm">Password</label>
                    <input name="password" type="text" value="{{old('password')}}"  class="w-full rounded py-2 border border-gray-400  @error('password') border-red-600 @enderror">
                    @error('password')<small class="text-xs text-red-600">{{$message}}</small>@enderror
                </div>

                <div class="form-control mb-2">
                    <label for="" class="text-sm">{{__('setting.user_language')}}</label>
                    <select name="language" id="" class="w-full rounded py-2 border border-gray-400">
                        <option value="id" @if(old('language') == 'id') selected @endif>Bahasa Indonesia</option>
                        <option value="en" @if(old('language') == 'en') selected @endif>English</option>
                    </select>
                </div>

                <div class="form-control">
                    <label for="" class="text-sm">{{__('setting.user_timezone')}}</label>
                    <select name="timezone" id="timezone" class="w-full rounded py-2 border border-gray-400 timezone" >
                        @foreach (timezone_identifiers_list() as $item)
                        <option value="{{$item}}" @if(old('timezone') == $item) selected @endif>{{$item}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="modal-action mt-8 text-right">
                <label for="addUser" class="bg-red-600 hover:bg-red-700 cursor-pointer py-2 px-4 rounded-lg text-white">{{__('general.cancel')}}</label>
                <button type="submit" class="bg-primary hover:bg-secondary py-2 px-8 rounded-lg text-white">{{__('general.save')}}</button>
            </div>
            </form>
        </div>
    </div>

    <input type="checkbox" id="editUser" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-2xl">{{__('setting.edit_user')}}</h3>
            <form action="" method="POST" id="updateUser">
            @csrf @method('PUT')
            <div class="mt-3 mb-4">
                <div class="form-control mb-2">
                    <label for="" class="text-sm">{{__('setting.username')}}</label>
                    <input name="name" id="editName" type="text" value="{{old('name')}}" class="w-full rounded py-2 border border-gray-400 @error('name') border-red-600 @enderror" required>
                </div>

                <div class="form-control mb-2">
                    <label for="" class="text-sm">{{__('setting.user_email')}}</label>
                    <input name="email" id="editEmail" type="text" value="{{old('email')}}"  class="w-full rounded py-2 border border-gray-400 @error('email') border-red-600 @enderror" required>
                    @error('email')<small class="text-xs text-red-600">{{$message}}</small>@enderror
                </div>

                <div class="form-control mb-2">
                    <label for="" class="text-sm">{{__('setting.user_language')}}</label>
                    <select name="language" id="editLanguage" class="w-full rounded py-2 border border-gray-400">
                        <option value="id" @if(old('language') == 'id') selected @endif>Bahasa Indonesia</option>
                        <option value="en" @if(old('language') == 'en') selected @endif>English</option>
                    </select>
                </div>

                <div class="form-control">
                    <label for="" class="text-sm">{{__('setting.user_timezone')}}</label>
                    <select name="timezone" id="editTimezone" class="w-full rounded py-2 border border-gray-400 timezone" >
                        @foreach (timezone_identifiers_list() as $item)
                        <option value="{{$item}}" @if(old('timezone') == $item) selected @endif>{{$item}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="modal-action mt-8 text-right">
                <label for="editUser" class="bg-red-600 hover:bg-red-700 cursor-pointer py-2 px-4 rounded-lg text-white">{{__('general.cancel')}}</label>
                <button type="submit" class="bg-primary hover:bg-secondary py-2 px-8 rounded-lg text-white">{{__('general.save')}}</button>
            </div>
            </form>
        </div>
    </div>

    <input type="checkbox" id="resetPass" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-2xl">{{__('general.reset_password')}}</h3>
            <form action="" method="POST" id="resetPassForm">
            @csrf @method('PUT')
            <div class="mt-3 mb-4">
                <div class="form-control mb-2">
                    <label for="" class="text-sm">Password</label>
                    <input name="password" id="editName" type="text" value="{{old('name')}}" class="w-full rounded py-2 border border-gray-400 @error('name') border-red-600 @enderror" required>
                </div>
            </div>

            <div class="modal-action mt-8 text-right">
                <label for="resetPass" class="bg-red-600 hover:bg-red-700 cursor-pointer py-2 px-4 rounded-lg text-white">{{__('general.cancel')}}</label>
                <button type="submit" class="bg-primary hover:bg-secondary py-2 px-8 rounded-lg text-white">{{__('general.save')}}</button>
            </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
<script src="{{asset('js/select2.min.js')}}"></script>
<script>
    
    const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;     
    $("#timezone").val(timezone);

    const setEditForm = el => {
        $("#editName").val($(el).data('name'))
        $("#editEmail").val($(el).data('email'))
        $("#editLanguage").val($(el).data('language'))
        $("#editTimezone").val($(el).data('timezone'))
        $("#updateUser").prop('action', $(el).data('action'))

        $(document).ready(function() {
            $('#editTimezone').select2();
        });
    }

    const setResetPass = el => {
        $("#resetPassForm").prop('action', $(el).data('action'))
    }

    $(document).ready(function() {
        $('#timezone').select2();
    });

    $("#createUser").on('submit', () => {
        $("#addUser").prop('checked',false)
    });

    

</script>
@endpush