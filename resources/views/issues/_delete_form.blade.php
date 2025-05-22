<form method="POST" action="{{ route('issues.destroy', {id: issue->id} ) }}" onsubmit="return confirm('Delete?');">
    @csrf
    @method('DELETE')
    <button>Delete</button>
</form>
