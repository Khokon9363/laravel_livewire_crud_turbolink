<div>
    <div class="container mt-3 text-center">
        <div class="row m-auto">
            <div class="col-sm-9">
                <form wire:submit.prevent="search">
                    <span class="text-danger">
                        @error('search') 
                            {{ $message }}
                        @enderror
                    </span>
                    <input type="text" wire:keyup="search" wire:model.debounce.500ms="search" class="form-control mb-2" placeholder="Search from here ..">
                </form>
                <table class="table table-hover table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Number of Books</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                    @foreach($books as $key => $book)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $book->number }}</td>
                        <td>{{ $book->name }}</td>
                        <td><img src="{{ asset('storage/photos/'.$book->image) }}" style="height: 32px; width: auto;"></td>
                        <td>{{ $book->created_at->diffForHumans() }}</td>
                        <td>
                            <button class="btn btn-info btn-sm" wire:click="edit({{ $book->id }})">Edit</button>
                            <button class="btn btn-danger btn-sm" wire:click="destroy({{ $book->id }})">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </table>
                <div>{{ $books->links() }}</div>
            </div>
            <div class="col-sm-3">
                @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if ($image)
                    <img src="{{ $image->temporaryUrl() }}" style="height: 189px;width: auto;">
                @endif
                <form wire:submit.prevent="{{ $editMode ? 'update' : 'store' }}" enctype="multipart/form-data">
                    <span class="text-danger">
                        @error('number') 
                            {{ $message }}
                        @enderror
                    </span>
                    <input type="number" wire:model.debounce.500ms="number" wire:keyup="check" class="form-control mb-2" placeholder="Write the number of books">
                    <span class="text-danger">
                        @error('name') 
                            {{ $message }}
                        @enderror
                    </span>
                    <input type="text" wire:model.debounce.500ms="name" wire:keyup="check" class="form-control mb-2" placeholder="Write the book name">
                    <span class="text-danger">
                        @error('image') 
                            {{ $message }}
                        @enderror
                    </span>

                    <div wire:loading wire:target="image">Loading to preview...</div>
                    <div x-show="isUploading">
                        <progress max="100" x-bind:value="progress"></progress>
                    </div>
                    <div
                        x-data="{ isUploading: false, progress: 0 }"
                        x-on:livewire-upload-start="isUploading = true"
                        x-on:livewire-upload-finish="isUploading = false"
                        x-on:livewire-upload-error="isUploading = false"
                        x-on:livewire-upload-progress="progress = $event.detail.progress"
                    >
                    </div>

                    <input type="file" wire:model.debounce.500ms="image" id="upload{{ $iteration }}" wire:change="check" class="form-control mb-2">
                    <input type="submit" value="Save" class="btn btn-info form-control">
                </form>
            </div>
        </div>
    </div>
</div>