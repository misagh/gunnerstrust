@extends('layouts.app')

@section('title', 'نوشتن تحلیل')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <span>موضوع:</span>
                <span>{{ $challenge->title }}</span>
            </div>
            <div class="card-body">
                @if ($challenge->finished_at->isFuture())
                <div class="alert alert-info">
                    <p>مقاله شما پس از بازبینی و ویرایش توسط مدیریت سایت، منتشر خواهد شد. در نظر داشته باشید که هنگام بازبینی مقاله ها، نکات زیر مد نظر قرار خواهد گرفت. بنابراین لطفا موارد زیر را هنگام نوشتن رعایت فرمایید.</p>
                    <ul class="mb-0">
                        <li>عنوان مقاله باید مختصر، گویا و متفاوت با واژه های موضوع چالش باشد.</li>
                        <li>هنگام نوشتن خلاصه مقاله در نظر داشته باشید که تعداد حروف آن بین ۱۵۰ تا ۱۶۰ کاراکتر باشد.</li>
                        <li>انتخاب جمله های مناسب برای خلاصه مقاله به این دلیل مهم است که این جملات هنگام جستجوی مقاله شما در موتورهای جستجو نمایش داده میشود.</li>
                        <li>اگر تصویر خاصی برای مقاله خود مد نظر دارید، لینک تصویر را در قسمت مربوطه قرار دهید، در غیراین صورت پس از بازبینی، تصویری مناسب برای مقاله انتخاب خواهد شد.</li>
                        <li>متن مقاله شماباید حداقل دو پاراگراف و بیشتر از ۲۰۰ حرف باشد. در واقع سعی ما بر این است که متون حرفه ای تر و مفیدتر را در سایت منتشر کنیم.</li>
                        <li>پس از ذخیره تغییرات و ارسال مقاله برای بازبینی، متن شما توسط مدیریت سایت مورد بررسی و ویرایش قرار می گیرد و اگر شرایط لازم را داشته باشد، در سایت منتشر خواهد شد.</li>
                        <li>ممکن است پس از بررسی، مقاله شما نیاز به ویرایش داشته باشد. بنابراین لازم است که تغییرات مورد نظر را اعمال کنید و مقاله خود را دوباره برای بررسی ارسال نمایید.</li>
                    </ul>
                </div>
                @if (! empty($post->tip))
                    <div class="alert alert-warning">
                        <p class="font-weight-bold mb-1">مدیریت سایت به دلیل زیر متن شما را منتشر نکرده است:</p>
                        <p class="mb-0">{{ $post->tip }}</p>
                    </div>
                @endif
                <form action="" method="post">
                    @csrf
                    <div class="form-group">
                        <label>عنوان مقاله</label>
                        <input type="text" name="title" class="form-control" value="{{ $post->title ?? '' }}" required>
                        <small class="text-muted">لطفا عنوانی مختصر و گویا برای مقاله خود انتخاب کنید.</small>
                    </div>
                    <div class="form-group">
                        <label>خلاصه مقاله</label>
                        <input type="text" name="summary" class="form-control" value="{{ $post->summary ?? '' }}" maxlength="160" minlength="150" required>
                        <small class="text-muted">خلاصه مقاله شما باید بین ۱۵۰ تا ۱۶۰ حرف باشد.</small>
                    </div>
                    <div class="form-group">
                        <label>لینک تصویر پیشنهادی</label>
                        <input type="text" name="cover" value="{{ ! empty($post) && ! $post->verified ? $post->cover : '' }}" class="form-control" dir="ltr">
                        <small class="text-muted">اگر این فیلد را خالی بگذارید، مدیریت سایت برای مقاله شما تصویری انتخاب خواهد کرد.</small>
                    </div>
                    <div class="form-group">
                        <label>متن مقاله</label>
                        <textarea id="summernote" name="body" class="form-control" required>{{ $post->body ?? '' }}</textarea>
                    </div>
                    @if (! empty($post) && ! $post->verified && is_admin($auth))
                    <div class="form-group">
                        <label>دلیل منتشر نکردن</label>
                        <input name="tip" class="form-control" value="{{ $post->tip }}">
                    </div>
                    @endif
                    @if (empty($post) || ! $post->verified)
                    <button type="submit" class="btn btn-primary float-right mr-2">ذخیره تغییرات</button>
                    @endif
                    @if (! empty($post) && is_admin($auth))
                        <button type="submit" name="publish" class="btn btn-success float-right">انتشار مقاله</button>
                    @endif
                    @if (empty($post))
                        <a class="btn btn-secondary float-left" href="{{ route('challenges.lists') }}">بازگشت به موضوعات</a>
                    @else
                        <a class="btn btn-secondary float-left" href="{{ route('posts.lists') }}">بازگشت به مقالات</a>
                    @endif
                </form>
                @else
                    <div class="alert alert-danger">مهلت شرکت در این موضوع به اتمام رسیده است.</div>
                    <div class="text-center mt-4">
                        <a class="btn btn-info" href="{{ route('challenges.lists') }}">بازگشت به موضوعات</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
