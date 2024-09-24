<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create Catregories') }}
            </h2>
            <div>
                <a href="{{ route('categories.index') }}"
                    class="bg-primary hover:bg-blue-500 hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">All</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                <form id="FormTempleteForm" method="POST">
                    @csrf

                    <div class="mb-5">
                        <label for="category"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                        <select name="category" class="form-control" id="category">
                            <option value="">Select Category</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category')
                            <div class="valid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="name"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" id="name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Enter Name" />
                        @error('name')
                            <div class="valid-feedback">{{ $message }}</div>
                        @enderror

                        <div class="my-5 pt-5">
                            <label for="description"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                            <textarea type="text" name="description" id="description"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Enter Description:">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="valid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                       
                        <div id="fieldsContainer" class="p-4"></div>
                        <button type="button" class="bg-primary hover:bg-blue-500 hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded" id="addFieldBtn">Add New Field</button>
                        <div class="mt-5">
                            <button type="submit"
                                class="bg-primary hover:bg-blue-500 hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>

    <script>
        // Initial field count
        let fieldCount = 0;
    
        // Available field types
        const fieldTypes = [
            { value: 'text', label: 'Text Input' },
            { value: 'textarea', label: 'Textarea' },
            { value: 'number', label: 'Number' },
            { value: 'select', label: 'Select Dropdown' },
            { value: 'checkbox', label: 'Checkbox' },
            { value: 'radio', label: 'Radio Button' },
            { value: 'file', label: 'File Upload' },
            { value: 'date', label: 'Date Picker' },
            { value: 'time', label: 'Time Picker' },
            { value: 'datetime', label: 'DateTime Picker' }
        ];
    
        // Add new field when clicking "Add New Field" button
        document.getElementById('addFieldBtn').addEventListener('click', () => {
            addNewField();
        });
    
        // Function to add new field block
        function addNewField() {
            const fieldsContainer = document.getElementById('fieldsContainer');
            const fieldDiv = document.createElement('div');
            fieldDiv.className = 'field-group';
            fieldDiv.innerHTML = `
                <div class="mb-4">
                    <label>Field Label</label>
                    <input type="text" placeholder="Enter Field Label" name="fields[${fieldCount}][label]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                </div>
                <div class="mb-4">
                    <label>Field Type</label>
                    <select name="fields[${fieldCount}][type]"  class="field-type-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="">Select Field Type</option>
                        ${fieldTypes.map(type => `<option value="${type.value}">${type.label}</option>`).join('')}
                    </select>
                </div>
                {{-- Dynamic Field Container --}}
                <div class="dynamic-field-container" id="dynamicFieldContainer${fieldCount}"></div>

                <div class="mb-4">
                    <label>Placeholder</label>
                    <input type="text" placeholder="Enter Placeholder" name="fields[${fieldCount}][placeholder]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label>Required?</label>
                    <input type="checkbox" name="fields[${fieldCount}][required]" class="">
                </div>
                <hr class="my-4">
            `;
            fieldsContainer.appendChild(fieldDiv);
    
            const fieldTypeSelect = fieldDiv.querySelector('.field-type-select');
            const dynamicFieldContainer = fieldDiv.querySelector('.dynamic-field-container');
    
            fieldTypeSelect.addEventListener('change', function() {
                renderFieldType(this.value, dynamicFieldContainer, fieldCount);
            });
    
           
            fieldCount++;
        }

        function renderFieldType(type, container, count) {
            container.innerHTML = ''; 
            let fieldHTML = '';
    
            switch (type) {
                
                case 'select':
                case 'checkbox':
                case 'radio':
                    fieldHTML = `
                        <label>Options (comma separated)</label>
                        <textarea name="fields[${count}][options]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Option 1, Option 2, Option 3"></textarea>
                    `;
                    break;
                default:
                    fieldHTML = '';
            }
    
            container.innerHTML = fieldHTML; // Set the dynamic field
        }
    </script>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('FormTempleteForm');

        form.addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(form);
            // Ajax Call
            $.ajax({
                url: "{{ route('forms.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Handle success response
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.log(error);
                }
            });

        });

    });


</script>
</x-app-layout>
