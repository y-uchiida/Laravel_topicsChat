{{-- MassageService クラス を注入、以降で $message_serviceとして利用できる --}}
@inject('message_service', 'App\Services\MessageService')
@inject('image_service', 'App\Services\ImageService')

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Topics') }}
        </h2>
    </x-slot>



    <div class="container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <x-flash.bar />

        <div class="py-4 sm:px-6 lg:px-8">
            <div class="">
                {{ $topics->links() }}
            </div>
        </div>

        @foreach ($topics as $topic)
            <div class="py-12 sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg max-w-7xl sm:px-6 lg:px-8">
                    <div class="flex flex-row justify-between content-center py-4 border-b border-gray-200">

                        <h3 class="flex items-center space-x-4 m-0 text-base">
                            <span class="text-xl">
                                {{ $topic->name }}
                            </span>
                            <span
                                class="px-2 bg-indigo-500 rounded-sm text-sm text-white">{{ $topic->messages->count() }}</span>
                        </h3>

                        @if (Auth::guard('admin')->check())
                            {{-- Admin権限でログインしている場合、削除用のボタンを表示 --}}
                            <form method="POST" action="{{ route('admin.topics.destroy', $topic->id) }}">
                                @csrf
                                @method('DELETE') {{-- DELETE メソッドで送信されるようにディレクティブで指定 --}}
                                <input type="submit" value="トピックを削除" onclick="return confirm('トピックを削除します。よろしいですか？');"
                                    class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                            </form>
                        @endif

                    </div>
                    @foreach ($topic->messages as $message)
                        <div class="flex flex-col space-y-4 mb-4">
                            <h5 class="card-title">{{ $loop->iteration }}
                                名前：{{ $message->user->name }}：{{ $message->created_at }}
                            </h5>
                            <p class="card-text">{!! $message_service->insertHyperLink($message->body) !!}</p>
                            <div class="flex">
                                @forelse ($message->images as $image)
                                    <div class="basis-32">
                                        <img class="w-auto"
                                            src="{{ $image_service->createTemporaryUrl($image->file_path) }}"
                                            alt="{{ $image->file_path }}">
                                    </div>
                                @empty
                                @endforelse
                            </div>
                            <x-message-delete :topic="$topic" :message="$message" />
                        </div>
                    @endforeach
                    <hr class="my-2 border-b border-gray-200">
                    <div class="new_message_form">
                        <x-message-form :topic="$topic" />
                    </div>
                    <x-topic-links :topic="$topic" />
                </div>
            </div>
        @endforeach

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
                                        class="block text-sm font-medium text-gray-900 dark:text-gray-500">トピック名称</label>
                                    <input name="name" type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                                        id="topic-title" placeholder="トピック名称">
                                </div>
                                <div class="form-group">
                                    <label for="topic-first-content"
                                        class="block text-sm font-medium text-gray-900 dark:text-gray-500">内容</label>
                                    <textarea name="content" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
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
    </div>

</x-app-layout>
