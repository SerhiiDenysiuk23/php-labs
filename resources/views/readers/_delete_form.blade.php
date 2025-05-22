<form method="POST" action="{{ route('readers.destroy', {id: reader->id} ) }}" onsubmit="return confirm('Delete?');">
    @csrf
    @method('DELETE')
    <button>Delete</button>
</form>
