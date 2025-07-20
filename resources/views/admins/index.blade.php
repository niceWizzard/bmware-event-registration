@php
    $breadcrumbs = [
        [
            'link' => route('admin.index'),
            'text' => 'Admins',
        ],
    ];
@endphp
<x-auth-layout title="User List">
    <div class="  mx-auto container p-8 flex flex-col">
        <x-breadcrumb :breadcrumbs="$breadcrumbs" class="text-lg font-medium" />
        @if(auth()->user()->role === 1)
            <div class="flex justify-end gap-2">
                <a href="{{route('admin.create')}}" class="btn btn-primary">Create Admin</a>
            </div>
        @endif
        <div class="overflow-x-auto flex-1 h-full">
            <table class="table ">
                <!-- head -->
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Role</th>
                    @if(auth()->user()->is_superadmin)
                        <th>Email</th>
                        <th>Actions</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <th>{{$loop->iteration}}</th>
                        <td>{{$user->name}}</td>
                        <td>{{$user->admin_role}}</td>
                        @if(auth()->user()->is_superadmin)
                            <td x-data="{ show: false }" class="whitespace-nowrap">
                                <span
                                    x-text="show ? '{{ $user->email }}' : '{{ str_repeat('*', strlen($user->email)) }}'">
                                </span>
                                <button
                                    class="btn btn-sm ml-2 text-xs"
                                    @click="show = !show"
                                    x-text="show ? 'Hide' : 'Show'"
                                    type="button"
                                ></button>
                            </td>
                            <td>
                                @if(auth()->id() !== $user->id)
                                    <form
                                        method="post"
                                        action="{{route('admin.delete', $user->id)}}"
                                        x-data="{hasConfirmed: false}"
                                        @submit.prevent="if(hasConfirmed) $el.submit(); else hasConfirmed = true; "
                                    >
                                        @csrf
                                        <button type="submit" class="btn btn-error"
                                                x-text="hasConfirmed ? 'Delete now' : 'Delete'"
                                                @click.outside="hasConfirmed = false;"
                                        >
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-auth-layout>
