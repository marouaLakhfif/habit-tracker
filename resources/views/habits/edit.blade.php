@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Habit</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('habits.update', $habit) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label">Habit Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $habit->name }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ $habit->description }}</textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Icon</label>
                            <select name="icon" class="form-control">
                                <option value="✅" {{ $habit->icon == '✅' ? 'selected' : '' }}>✅ Checkmark</option>
                                <option value="🏃" {{ $habit->icon == '🏃' ? 'selected' : '' }}>🏃 Running</option>
                                <option value="📚" {{ $habit->icon == '📚' ? 'selected' : '' }}>📚 Reading</option>
                                <option value="💪" {{ $habit->icon == '💪' ? 'selected' : '' }}>💪 Workout</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Update Habit</button>
                        <a href="{{ route('habits.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection