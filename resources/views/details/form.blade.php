<div class="card mt-4">
    <div class="card-header font-weight-bold text-white bg-secondary">ویرایش اطلاعات هواداری</div>
    <div class="card-body">
        <form action="{{ route('details.edit') }}" method="post">
            @csrf
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">طرفدار آرسنال از سال</label>
                <div class="col-sm-10">
                    <select name="year" class="form-control">
                        @foreach(range(1990, intval(date('Y'))) as $year)
                            <option value="{{ $year }}" {{ ($profile->details->year ?? '') === $year || $year === intval(date('Y')) ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">بازیکن محبوب</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="player" value="{{ $profile->details->player ?? '' }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">مربی محبوب</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="manager" value="{{ $profile->details->manager ?? '' }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">اسطوره محبوب</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="legend" value="{{ $profile->details->legend ?? '' }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">تیم ملی محبوب</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="national" value="{{ $profile->details->national ?? '' }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">شماره پیراهن محبوب</label>
                <div class="col-sm-10">
                    <select name="number" class="form-control">
                        @foreach(range(1, 99) as $number)
                            <option value="{{ $number }}" {{ (intval($profile->details->number ?? '') === $number) ? 'selected' : '' }}>{{ $number }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">تیم محبوب بعد از آرسنال</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="team" value="{{ $profile->details->team ?? '' }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">بهترین لحظه فوتبالی</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="moment" value="{{ $profile->details->moment ?? '' }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">مختصری درباره من</label>
                <div class="col-sm-10">
                    <textarea rows="4" class="form-control" name="about">{{ $profile->details->about ?? '' }}</textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-success mt-3">ذخیره تغییرات</button>
        </form>
    </div>
</div>
