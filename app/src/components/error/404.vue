<template>
    <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        404 - Không tìm thấy trang
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-yellow"></i> Rất tiếc! Trang không tìm thấy.</h3>

          <p>
            Chúng tôi không thể tìm thấy trang bạn đang tìm kiếm. Trong khi đó, bạn có thể quay lại bảng điều khiển hoặc thử sử dụng mẫu tìm kiếm.
          </p>

          <form class="search-form">
            <div class="input-group">
              <input type="text" name="search" class="form-control" placeholder="Search">

              <div class="input-group-btn">
                <button type="submit" name="submit" class="btn btn-warning btn-flat"><i class="fa fa-search"></i>
                </button>
              </div>
            </div>
            <!-- /.input-group -->
          </form>
        </div>
        <!-- /.error-content -->
      </div>
      <!-- /.error-page -->
    </section>
    <!-- /.content -->
  </div>
</template>
<script>
export default{
  metaInfo: {
    title: '404 - Không tìm thấy trang | Chatbot Gobig',
  },
}
</script>