<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-center mb-4">Gemini Query Form</h5>
                    <form wire:submit.prevent="submit">
                        <div class="mb-3">
                            <label for="query" class="form-label">Query</label>
                            <input type="text" id="query" wire:model="query" class="form-control" placeholder="Enter your query here">
                            @error('query') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>

                    <div class="mt-3">
                        @if ($parsedQuestions)
                            <ul>
                                @foreach ($parsedQuestions as $question)
                                    <li><strong>{{ $question }}</strong></li>
                                @endforeach
                            </ul>
                        @elseif ($error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endif
                    </div>

                    
                </div>
            </div>
        </div>
    </div>
</div>
