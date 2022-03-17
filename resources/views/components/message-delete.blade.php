@if (Auth::guard('admin')->check())
    <form action="{{ route('admin.messages.destroy', [$topic, $message->id]) }}" method="post" class="my-2">
        @csrf
        @method('DELETE')
        <input
            type="submit"
            value="メッセージ削除"
            class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-4 py-1 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
            onclick="return confirm('メッセージを削除します。よろしいですか？')">
    </form>
@endif
