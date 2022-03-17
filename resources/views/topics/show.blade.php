{{-- MassageService クラス を注入、以降で $message_serviceとして利用できる --}}
@inject('message_service', 'App\Services\MessageService')
@inject('image_service', 'App\Services\ImageService')


<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between content-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __($topic->name) }}
            </h2>

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

    </x-slot>

    <x-flash.bar />


    <div class="container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-row-reverse py-4 sm:px-6 lg:px-8">
            <a
                @if (Auth::guard('admin')->check())
                    href="{{route('admin.topics.index')}}"
                @else
                    href="/topics"
                @endif
                class="text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800">
                トピック一覧へ戻る
            </a>
        </div>

        @foreach ($topic->messages as $message)
            <div class="py-8 sm:px-6 lg:px-8 mt-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg max-w-7xl sm:px-6 lg:px-8">
                    <div class="py-4 border-b border-gray-200">
                        <div class="flex flex-col space-y-4 mb-4">
                            <h5 class="card-title">{{ $loop->iteration }}
                                名前：{{ $message->user->name }}：{{ $message->created_at }}</h5>
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
                    </div>
                </div>
            </div>
        @endforeach

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h2 class="text-xl mb-4">メッセージを投稿</h2>
                        <x-message-form :topic="$topic" />
                    </div>
                </div>
            </div>
        </div>

    </div>


</x-app-layout>
