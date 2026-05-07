@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-plus"></i> Create New Habit</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('habits.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Habit Name *</label>
                        <input type="text" name="name" class="form-control form-control-lg" required placeholder="e.g., Walk 1 hour, Read a book">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Describe your habit..."></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Choose Icon</label>
                        <select name="icon" class="form-select">
                            <option value="✅">✅ Checkmark</option>
                            <option value="🏃">🏃 Running</option>
                            <option value="📚">📚 Reading</option>
                            <option value="💪">💪 Workout</option>
                            <option value="💧">💧 Water</option>
                            <option value="🧘">🧘 Meditation</option>
                            <option value="💻">💻 Coding</option>
                            <option value="🇨🇳">🇨🇳 Language</option>
                            <option value="🚶">🚶 Walking</option>
                            <option value="🍎">🍎 Healthy Eating</option>
                            <option value="😴">😴 Sleep</option>
                        </select>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save"></i> Create Habit
                        </button>
                        <a href="{{ route('habits.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection