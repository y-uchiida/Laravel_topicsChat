<div>
    @if (Auth::guard('admin')->check())
        <a href="{{ route('admin.topics.show', $topic->id) }}">全部読む</a>
        <a href="{{ route('admin.topics.show', $topic->id) }}">最新50</a>
        <a href="{{ route('admin.topics.show', $topic->id) }}">1-100</a>
        <a href="{{ route('admin.topics.index') }}">再読み込み</a>
    @else
        <a href="{{ route('topics.show', $topic->id) }}">全部読む</a>
        <a href="{{ route('topics.show', $topic->id) }}">最新50</a>
        <a href="{{ route('topics.show', $topic->id) }}">1-100</a>
        <a href="{{ route('topics.index') }}">再読み込み</a>
    @endif
</div>
