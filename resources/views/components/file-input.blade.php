<div
    x-data="{clearFile: false}"
>
    @if ($imageUrl)
        <div class="col-span-2 flex flex-col gap-2"
        >
            <h3 class="text-base">Current {{\Illuminate\Support\Str::ucfirst($name)}}</h3>
            <img src="{{ asset('storage/' . $imageUrl) }}"
                 alt="Current Banner"
                 class="object-cover"
                 x-show="!clearFile"
            >
            <label>
                <input name="{{'clear_'.$name}}" type="checkbox" x-model="clearFile" class="checkbox">
                Clear Banner Instead.
                <br>
                <span x-show="clearFile">Banner will be removed after submission.</span>
                @if($errors->has('clear_'.$name))
                    <p class="text-sm text-error">
                        {{$errors->first('clear_'.$name)}}
                    </p>
                @endif
            </label>
        </div>
    @endif
    <div class="flex flex-col" x-show="!clearFile">
        <fieldset class="fieldset w-full">
            <legend class="fieldset-legend">{{$label}}</legend>
            <input type="file" name="{{$name}}" class="file-input w-full"/>
            @if($tip)
                <label class="label">{{$tip}}</label>
            @endif
            @if($errors->has($name))
                <p class="text-sm text-error">
                    {{$errors->first($name)}}
                </p>
            @endif
        </fieldset>
    </div>
</div>
