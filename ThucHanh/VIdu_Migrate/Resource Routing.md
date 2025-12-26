



Cách 1 (Thủ công - Manual Definition): Bạn tự tay khai báo từng dòng một cho từng hành động (URL nào -> gọi hàm nào -> tên route là gì).





use Illuminate\\Support\\Facades\\Route; 

use App\\Http\\Controllers\\PostController; 



<?php 

use Illuminate\\Support\\Facades\\Route; 

use App\\Http\\Controllers\\PostController; 

// returns the home page with all posts 

Route::get('/', PostController::class .'@index')->name('posts.index'); 

// returns the form for adding a post 

Route::get('/posts/create', PostController::class . '@create')

>name('posts.create'); 

// adds a post to the database 

Route::post('/posts', PostController::class .'@store')

>name('posts.store'); 

// returns a page that shows a full post 

Route::get('/posts/{post}', PostController::class .'@show')

>name('posts.show'); 

// returns the form for editing a post 

Route::get('/posts/{post}/edit', PostController::class .'@edit')

>name('posts.edit'); 

// updates a post 

Route::put('/posts/{post}', PostController::class .'@update')

>name('posts.update'); 

// deletes a post 

Route::delete('/posts/{post}', PostController::class .'@destroy')

>name('posts.destroy');





STT	Phương thức(Method)	Đường dẫn (URI)		Gọi vào hàm (Action)	Chức năng

1	GET			/employees		index()			Hiển thị danh sách nhân viên

2	GET			/employees/create	create()		Hiển thị form thêm mới

3	POST			/employees		store()			Lưu dữ liệu mới vào CSDL

4	GET			employees/{id}		show()			Xem chi tiết 1 nhân viên

5	GET			/employees/{id}/edit	edit()			Hiển thị form sửa

6	PUT/PATCH		/employees/{id}		update()		Lưu cập nhật vào CSDL

7	DELETE			/employees/{id}		destroy()		Xóa nhân viên



Cách 2 (Route::resource): Đây là một "đường tắt" (shortcut) của Laravel. Chỉ cần 1 dòng code, Laravel sẽ tự động sinh ra đủ 7 routes chuẩn RESTful tương ứng với 7 hành động CRUD (Index, Create, Store, Show, Edit, Update, Destroy).





**Bước 1**: Nhận diện (Input)

Route sẽ nhìn vào 2 thông tin quan trọng nhất của yêu cầu:



Đường dẫn (URI): Ví dụ /employees, /employees/create, /posts/5.



Phương thức (HTTP Method): GET, POST, PUT, DELETE.



**Bước 2:** So khớp (Matching)

Laravel sẽ mang 2 thông tin trên đi dò trong file routes/web.php. Nó dò từ trên xuống dưới xem có dòng nào khớp không.



Ví dụ 1: Khách gửi GET /employees. -> Route thấy khớp với dòng Route::resource('employees', ...) (phần index). -> Quyết định: Gọi hàm index().



Ví dụ 2: Khách gửi POST /employees. -> Vẫn là đường dẫn đó, nhưng method là POST. -> Route thấy khớp với quy tắc lưu trữ. -> Quyết định: Gọi hàm store().



**Bước 3**: Điều hướng (Dispatch)

Sau khi tìm thấy cặp đôi hoàn hảo (URL + Method), Route sẽ khởi tạo Controller tương ứng và chạy hàm (Action) được chỉ định. Nếu dò hết file mà không thấy ai khớp? -> Route trả về lỗi 404 Not Found.



3\. Giải thích sâu về Route::resource (Dành cho vấn đáp)

Nếu thầy cô hỏi: "Tại sao cùng một đường dẫn /employees mà lúc thì nó hiện danh sách, lúc thì nó lưu dữ liệu?"



Câu trả lời: "Dạ thưa thầy/cô, đó là nhờ vào HTTP Method ạ. Route::resource thông minh ở chỗ nó phân biệt hành động dựa trên phương thức gửi đi:



Nếu trình duyệt gửi phương thức GET vào /employees -> Route hiểu là muốn lấy dữ liệu -> Nó gọi hàm index.



Nếu trình duyệt gửi phương thức POST vào /employees -> Route hiểu là muốn gửi/lưu dữ liệu mới -> Nó gọi hàm store.



Nhờ cơ chế này mà code backend phân biệt được hành vi của người dùng dù đường dẫn giống hệt nhau ạ."







**Người dùng (Browser) ⬇️ (Gửi Request: GET /employees) Route (Lễ tân - web.php) ⬇️ (So khớp: À, ông này muốn xem danh sách!) Controller (Bếp trưởng - EmployeeController@index) ⬇️ (Xử lý dữ liệu) View (Món ăn) ⬇️ (Trả về HTML) Người dùng (Browser)**









--------------------**THÊM**------------------------



"Thưa thầy, nút này là một thẻ a trỏ đến route employees.create. Khi nhấn vào, trình duyệt gửi request GET lên server. Router điều hướng vào hàm create() của Controller. Hàm này lấy danh sách phòng ban từ Database, sau đó trả về View hiển thị Form nhập liệu cho người dùng ạ."





-------------------**-SỬA**------------------------





"Thưa thầy, nút Sửa khác nút Thêm ở chỗ nó truyền theo ID của nhân viên lên URL. Controller dựa vào ID đó để truy vấn dữ liệu cũ và đổ vào Form cho người dùng nhìn thấy trước khi chỉnh sửa ạ."





--------------------**XÓA**-------------------------

"Thưa thầy, quy trình xóa có 2 điểm đặc biệt: 1. Phải có Hộp thoại xác nhận (Confirm) bằng JavaScript ở phía trình duyệt để tránh xóa nhầm. 2. Phải dùng kỹ thuật Method Spoofing (@method('DELETE')) để gửi phương thức DELETE lên Server, vì Form HTML mặc định không hỗ trợ phương thức này ạ."



------------------------------

**Tại sao thẻ Form là POST mà lại có @method('PUT')?**: "Thưa thầy, vì chuẩn HTML5 chỉ hỗ trợ 2 phương thức là GET và POST. Nó không hiểu PUT hay DELETE. Để tuân thủ chuẩn RESTful (Update phải dùng PUT), Laravel cung cấp chỉ thị @method('PUT'). Khi form được gửi đi, Laravel sẽ tạo một trường ẩn \_method mang giá trị PUT để đánh lừa Router, giúp Router hiểu đây là yêu cầu cập nhật ạ."



------------------------------

**Hàm old('name', $employee->name) có ý nghĩa gì?**

Giải thích:



"Hàm này giúp giữ lại dữ liệu và điền giá trị mặc định, hoạt động theo ưu tiên:

Tham số đầu old('name'): Nếu người dùng sửa tên rồi bấm Lưu nhưng bị lỗi (ví dụ chưa nhập Email), trang web load lại sẽ hiển thị cái tên mới vừa nhập (để họ đỡ phải gõ lại).

Tham số sau $employee->name: Nếu không có dữ liệu cũ (lần đầu vào trang sửa), nó sẽ lấy tên từ Database để hiển thị lên."



---------------------------------

**Logic trong thẻ <select> (Dropdown) hoạt động ra sao?**



**{{ (old('department\_id', $employee->department\_id) == $dept->id) ? 'selected' : '' }}**



Giải thích:



"Đây là toán tử 3 ngôi (Ternary Operator). Nó so sánh ID phòng ban của nhân viên hiện tại với ID phòng ban trong vòng lặp.

Nếu Bằng nhau: Nó in ra chữ selected (để trình duyệt chọn sẵn mục đó).

Nếu Không bằng: Nó in ra chuỗi rỗng (không chọn). Cách này giúp hiển thị đúng phòng ban hiện tại của nhân viên ạ."



---------------------------------

**Biến $errors lấy ở đâu ra?**

Giải thích:



"Biến $errors này được Laravel tự động chia sẻ cho tất cả các View khi quá trình Validation (ở Controller) thất bại. Nếu có lỗi, hàm $errors->any() trả về true và vòng lặp sẽ in danh sách lỗi ra màn hình cho người dùng thấy ạ."



----------------------------------------





