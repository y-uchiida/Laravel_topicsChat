<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Topics') }}
        </h2>
    </x-slot>

    <x-flash.bar />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-xl mb-4">新しいトピックを作成</h2>
                    <form method="POST" action="{{ route('topics.store') }}">
                        @csrf
                        <div class="flex flex-col space-y-4">
                            <div class="form-group">
                                <label for="topic-title"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-500">トピック名称</label>
                                <input name="name" type="text"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                                    id="topic-title" placeholder="トピック名称">
                            </div>
                            <div class="form-group">
                                <label for="topic-first-content"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-500">内容</label>
                                <textarea name="content"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                                    id="topic-first-content" rows="3"></textarea>
                            </div>

                            <div class="form-group flex flex-row-reverse">
                                <button type="submit"
                                    class="text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800">
                                    トピックを作成
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
