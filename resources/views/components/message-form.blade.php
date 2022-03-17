@if(Auth::check())
    {{-- User権限でログインしている場合、メッセージ投稿フォームを表示 --}}
    <form method="POST" action="{{ route('messages.store', $topic->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="flex flex-col space-y-4">
            <div class="form-group">
                <label for="message-content" class="block text-sm font-medium text-gray-900 dark:text-gray-500">内容</label>
                <textarea name="body"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                    id="message-content" rows="3"></textarea>
            </div>

            <div class="form-group">
                <label for="message-attached-images"
                    class="block text-sm font-medium text-gray-900 dark:text-gray-500">添付ファイル</label>
                <input type="file" id="message-attached-images" name="images[]" multiple />
            </div>

            <div class="form-group flex flex-row-reverse">
                <button type="submit"
                    class="text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800">
                    メッセージを投稿
                </button>
            </div>
        </div>
    </form>
@endif
