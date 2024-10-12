@extends('main')

@section('title')
Quản lý giống dê
@endsection

@section('content')
<h1>List of Goats</h1>
<h3>1.Goat breeds:</h3>

<h4>Saanen</h4>
<img src="{{asset('img/Saanen.png')}}" alt="Hình ảnh dê Saanen">    
<h5>Xuất xứ:</h5>
Thụy Sĩ  
<h5>Kích thước</h5>
Lớn, con cái nặng 65-80 kg, con đực nặng 85-100 kg
<h5>Màu sắc</h5>
Thường có màu trắng hoặc kem
<h5>Đặc điểm</h5>
Hiền lành, dễ nuôi, thích nghi tốt với các vùng khí hậu ôn hòa
<h5>Ghi chú</h5>
Là giống dê sữa năng suất cao, có thể cho từ 3-5 lít sữa mỗi ngày


            <h3>Goat breeds</h3>  
            <h5>Xuất xứ</h5>
            <h5>Kích thước</h5>
            <h5>Màu sắc</h5>
            <h5>Đặc điểm</h5>
            <h5>Ghi chú</h5>
    
            
<h3>2.Goat breeds</h3>
<h4>Nubian</h4>
<img src="{{asset('img/Nubian.png')}}" alt="Hình ảnh dê Nubian">           
<h5>Xuất xứ</h5>
Bắc Phi và Trung Đông
<h5>Kích thước</h5>
Trung bình, con cái nặng 60-70 kg, con đực nặng 75-90 kg
<h5>Màu sắc</h5>
Đa dạng, từ nâu, đen đến trắng, thường có đốm
<h5>Đặc điểm</h5>
Tai dài rủ xuống, tính cách hoạt bát, khả năng thích nghi với khí hậu nóng rất tốt
<h5>Ghi chú</h5>
Sữa có hàm lượng chất béo cao (từ 4-5%), phù hợp để làm phô mai


<h3>3.Goat breeds</h3>
<h4>Alpine</h4>
<img src="{{asset('img/Nubian.png')}}" alt="Hình ảnh dê Nubian">           
<h5>Xuất xứ</h5>
Pháp
<h5>Kích thước</h5>
Trung bình đến lớn, con cái nặng 55-65 kg, con đực nặng 80-100 kg
<h5>Màu sắc</h5>
Đa dạng từ đen, nâu, trắng đến kết hợp nhiều màu
<h5>Đặc điểm</h5>
Dê khỏe mạnh, dễ thích nghi với nhiều loại môi trường, chịu lạnh tốt
<h5>Ghi chú</h5>
Cho sữa với sản lượng cao, khoảng 3-4 lít/ngày
      

<h3>4.Goat breeds</h3>
<h4>Boer</h4>
<img src="{{asset('img/Nubian.png')}}" alt="Hình ảnh dê Nubian">           
<h5>Xuất xứ</h5>
Nam Phi
<h5>Kích thước</h5>
Rất lớn, con cái nặng 80-100 kg, con đực nặng 110-135 kg
<h5>Màu sắc</h5>
Chủ yếu trắng với đầu nâu hoặc đỏ
<h5>Đặc điểm</h5>
Giống dê thịt nổi tiếng, có tốc độ tăng trưởng nhanh, chất lượng thịt tốt
<h5>Ghi chú</h5>
Chịu hạn tốt, dễ nuôi ở các vùng nhiệt đới
       
<h3>5.Goat breeds</h3>
<h4>Kiko</h4>
<img src="{{asset('img/Nubian.png')}}" alt="Hình ảnh dê Nubian">           
<h5>Xuất xứ</h5>
New Zealand
<h5>Kích thước</h5>
Trung bình đến lớn, con cái nặng 55-65 kg, con đực nặng 80-100 kg
<h5>Màu sắc</h5>
Chủ yếu là trắng, nhưng cũng có nhiều màu khác
<h5>Đặc điểm</h5>
Dê khỏe mạnh, dễ thích nghi với nhiều loại môi trường, chịu lạnh tốt
<h5>Ghi chú</h5>
Cho sữa với sản lượng cao, khoảng 3-4 lít/ngày

            <th>Kiko</th>
            <td>New Zealand</td>
            <td>Trung bình, con cái nặng 55-65 kg, con đực nặng 80-100 kg</td>
            <td>Chủ yếu là trắng, nhưng cũng có nhiều màu khác</td>
            <td>Là giống dê thịt, có sức khỏe tốt, khả năng chống chọi với bệnh tật cao, thích nghi với điều kiện khắc nghiệt</td>
            <td>Nhanh và có thể tự nuôi ăn cỏ mà không cần nhiều sự chăm sóc</td>
    
            <th>Miniature</th>
            <td>Mỹ, lai giữa các giống dê lùn từ Tây Phi</td>
            <td>Rất nhỏ, con trưởng thành chỉ nặng từ 15-30 kg</td>
            <td>Đa dạng từ đen, trắng, xám, nâu đến kết hợp nhiều màu</td>
            <td> Thường nuôi làm thú cưng, rất thân thiện, hiền lành và dễ nuôi</td>
            <td></td>
        </tr>
        <tr>
            <th>Nigerian Dwarf</th>
            <td>Tây Phi</td>
            <td>Nhỏ, con cái nặng khoảng 25-30 kg, con đực nặng khoảng 35-40 kg</td>
            <td>Đa dạng, có nhiều màu từ trắng, đen, nâu đến hoa văn</td>
            <td>Dê nhỏ, dễ chăm sóc, thân thiện, phù hợp làm dê kiểng</td>
            <td>Tuy nhỏ nhưng sản lượng sữa cao, sữa ngọt và béo, rất thích hợp để nuôi lấy sữa</td>
        </tr>
        <tr>
            <th>Laitong</th>
            <td>Việt Nam, thuộc khu vực miền núi phía Bắc</td>
            <td>Nhỏ, con cái nặng khoảng 30-35 kg, con đực nặng khoảng 40-50 kg</td>
            <td>Đen hoặc nâu, thân hình thon gọn</td>
            <td>Khả năng leo trèo và di chuyển trên địa hình đồi núi tốt, thường được nuôi ở các vùng dân tộc thiểu số</td>
            <td>Tốt với môi trường khí hậu núi cao</td>
        </tr>
        <tr>
            <th>Mường Khương</th>
            <td>Việt Nam, tỉnh Lào Cai (vùng núi Mường Khương)</td>
            <td>Trung bình, con cái nặng khoảng 35-40 kg, con đực nặng khoảng 45-55 kg</td>
            <td>Chủ yếu là màu nâu hoặc đen</td>
            <td>Khỏe mạnh, chịu lạnh tốt, di chuyển giỏi trên địa hình đồi núi</td>
            <td>Trung bình, chủ yếu nuôi để lấy thịt</td>
        </tr>
        <tr>
            <th>Maltese</th>
            <td>Trung bình, chủ yếu nuôi để lấy thịt</td>
            <td>Trung bình, con cái nặng 40-50 kg, con đực nặng khoảng 60-70 kg</td>
            <td>Chủ yếu là trắng</td>
            <td>Giống dê sữa nổi tiếng, phù hợp với vùng khí hậu Địa Trung Hải</td>
            <td>Sữa tốt, sản lượng cao, có thể lên đến 4-5 lít/ngày</td>        
        </tr>
       
    </tbody>
</table>

@endsection