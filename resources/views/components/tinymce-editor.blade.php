<div class="mb-4">
    <label for="{{ $id }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    <textarea 
        name="{{ $name }}" 
        id="{{ $id }}" 
        class="tinymce-editor mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
    >{{ $value }}</textarea>
    
    @if(isset($hint))
        <p class="text-sm text-gray-500 mt-1">{{ $hint }}</p>
    @endif
    
    @error($name)
        <span class="text-red-600 text-sm">{{ $message }}</span>
    @enderror
</div>
