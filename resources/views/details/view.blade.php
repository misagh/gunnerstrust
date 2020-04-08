<div class="row text-center mb-3 mb-md-0">
    <div class="col-lg-6 d-flex align-items-stretch">
        <div class="card shadow bg-light mb-3 w-100">
            <div class="card-body">
                <label class="text-danger font-weight-bold">طرفدار آرسنال از سال</label>
                <span class="d-block">{{ $profile->details->year }}</span>
            </div>
        </div>
    </div>
    <div class="col-lg-6 d-flex align-items-stretch">
        <div class="card shadow bg-light mb-3 w-100">
            <div class="card-body">
                <label class="text-danger font-weight-bold">بازیکن محبوب</label>
                <span class="d-block">{{ $profile->details->player }}</span>
            </div>
        </div>
    </div>
    <div class="col-lg-6 d-flex align-items-stretch">
        <div class="card shadow bg-light mb-3 w-100">
            <div class="card-body">
                <label class="text-danger font-weight-bold">مربی محبوب</label>
                <span class="d-block">{{ $profile->details->manager }}</span>
            </div>
        </div>
    </div>
    <div class="col-lg-6 d-flex align-items-stretch">
        <div class="card shadow bg-light mb-3 w-100">
            <div class="card-body">
                <label class="text-danger font-weight-bold">اسطوره محبوب</label>
                <span class="d-block">{{ $profile->details->legend }}</span>
            </div>
        </div>
    </div>
    <div class="col-lg-6 d-flex align-items-stretch">
        <div class="card shadow bg-light mb-3 w-100">
            <div class="card-body">
                <label class="text-danger font-weight-bold">تیم ملی محبوب</label>
                <span class="d-block">{{ $profile->details->national }}</span>
            </div>
        </div>
    </div>
    <div class="col-lg-6 d-flex align-items-stretch">
        <div class="card shadow bg-light mb-3 w-100">
            <div class="card-body">
                <label class="text-danger font-weight-bold">شماره پیراهن محبوب</label>
                <span class="d-block">{{ $profile->details->number }}</span>
            </div>
        </div>
    </div>
    <div class="col-lg-6 d-flex align-items-stretch">
        <div class="card shadow bg-light mb-3 w-100">
            <div class="card-body">
                <label class="text-danger font-weight-bold">تیم محبوب بعد از آرسنال</label>
                <span class="d-block">{{ $profile->details->team }}</span>
            </div>
        </div>
    </div>
    <div class="col-lg-6 d-flex align-items-stretch">
        <div class="card shadow bg-light mb-3 w-100">
            <div class="card-body">
                <label class="text-danger font-weight-bold">بهترین لحظه فوتبالی</label>
                <span class="d-block">{{ $profile->details->moment }}</span>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card shadow bg-light mb-3 w-100">
            <div class="card-body">
                <label class="text-danger font-weight-bold">مختصری درباره من</label>
                <span class="d-block">{{ $profile->details->about }}</span>
            </div>
        </div>
    </div>
</div>
