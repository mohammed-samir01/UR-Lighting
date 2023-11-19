<div class="card mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6 col-lg-6">
                <div class="form-group">
                    <label
                        class="title-color d-flex">{{translate('otp')}}</label>
                    <input class="form-control" type="text" name="otp"
                           placeholder="otp">
                </div>
            </div>
            <div class="col-sm-6 col-lg-6">
                <div class="form-group">
                    <label
                        class="title-color d-flex">{{translate('company_Name')}}</label>
                    <input class="form-control" type="text" name="organization_name"
                           value="{{ $business_setting['company_name'] }}"
                           placeholder="New Business">
                </div>
            </div>
            <div class="col-sm-6 col-lg-6">
                <div class="form-group">
                    <label
                        class="title-color d-flex">{{translate('email')}}</label>
                    <input class="form-control" type="text" name="email"
                           value="{{ $business_setting['company_email'] }}"
                           placeholder="New Business">
                </div>
            </div>
            <div class="col-sm-6 col-lg-6">
                <div class="form-group">
                    <label class="title-color d-flex">{{translate('tax_num')}}</label>
                    <input type="text" value="{{ $business_setting['tax_num']??'' }}"
                           name="uid" class="form-control"
                           placeholder="{{translate('tax_num')}}"
                    >
                </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="form-group">
                    <label class="title-color d-flex">{{translate('company_address')}}</label>
                    <input type="text" value="{{ $business_setting['shop_address'] }}"
                           name="address" class="form-control"
                           placeholder="{{translate('your_shop_address')}}"
                           required>
                </div>
            </div>
        </div>
        <div class="text-right" style="margin-top: 20px">
            <button type="submit" class="btn btn-primary px-5">{{translate('save')}}</button>
        </div>

    </div>
</div>
