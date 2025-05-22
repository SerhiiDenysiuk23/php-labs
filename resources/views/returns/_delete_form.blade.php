<form method="POST" action="{{ route('returns.destroy', {id: bookReturn->id} ) }}" onsubmit="return confirm('Delete?');">
    @csrf
    @method('DELETE')
    <button>Delete</button>
</form>
