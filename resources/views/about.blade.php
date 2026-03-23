@extends('layouts.master')

@section('title', 'Về Chúng Tôi - ElectroGear')

@section('content')
<div class="p-5 mb-5 bg-dark-custom text-white border-bottom border-danger shadow rounded">
    <div class="row align-items-center mb-5">
        <div class="col-lg-7">
            <h2 class="fw-bold mb-4 text-laravel border-start border-danger border-4 ps-3">Về ElectroGear</h2>
            <p class="fs-5 text-white mb-4">ElectroGear là cửa hàng chuyên cung cấp linh kiện điện tử, vi điều khiển, module và cảm biến hàng đầu cho sinh viên, kỹ sư và những người đam mê công nghệ tại Việt Nam.</p>
            <p class="text-white">Chúng tôi cam kết mang đến những sản phẩm chất lượng với mức giá tốt nhất, đi kèm với dịch vụ hỗ trợ kỹ thuật tận tâm. Cho dù bạn đang làm đồ án môn học, nghiên cứu khoa học hay phát triển sản phẩm thương mại, ElectroGear luôn đồng hành cùng thành công của bạn.</p>
        </div>
        <div class="col-lg-5 text-center d-none d-lg-block">
            <i class="bi bi-cpu text-laravel" style="font-size: 10rem; opacity: 0.8;"></i>
        </div>
    </div>

    <h3 class="fw-bold mb-4 text-white border-start border-danger border-4 ps-3">Tại sao chọn chúng tôi?</h3>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card bg-dark border-secondary h-100 p-3 text-center" style="border-radius: 12px; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <i class="bi bi-award text-laravel display-5 mb-3"></i>
                <h5 class="text-white fw-bold">Chất lượng đảm bảo</h5>
                <p class="text-white small mb-0">Tất cả sản phẩm đều được kiểm tra kỹ lưỡng trước khi đến tay khách hàng.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-dark border-secondary h-100 p-3 text-center" style="border-radius: 12px; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <i class="bi bi-truck text-laravel display-5 mb-3"></i>
                <h5 class="text-white fw-bold">Giao hàng siêu tốc</h5>
                <p class="text-white small mb-0">Hỗ trợ ship hỏa tốc trong nội thành và giao hàng nhanh toàn quốc.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-dark border-secondary h-100 p-3 text-center" style="border-radius: 12px; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <i class="bi bi-headset text-laravel display-5 mb-3"></i>
                <h5 class="text-white fw-bold">Hỗ trợ kỹ thuật</h5>
                <p class="text-white small mb-0">Đội ngũ kỹ thuật viên giàu kinh nghiệm luôn sẵn sàng giải đáp thắc mắc.</p>
            </div>
        </div>
    </div>
</div>
@endsection
