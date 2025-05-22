<form method="POST" action="{{ route('authors.destroy', {id: author->id} ) }}" onsubmit="return confirm('Delete?');">
    @csrf
    @method('DELETE')
    <button>Delete</button>
</form>
