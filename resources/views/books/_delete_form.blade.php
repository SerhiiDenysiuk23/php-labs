<form method="POST" action="{{ route('books.destroy', {id: book->id} ) }}" onsubmit="return confirm('Delete?');">
    @csrf
    @method('DELETE')
    <button>Delete</button>
</form>
