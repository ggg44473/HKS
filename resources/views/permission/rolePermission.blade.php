{{-- 權限說明modal --}}
<div class="modal fade" id="rolePermission" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-12 text-center font-weight-bold"><h5>權限說明</h5></div>
                </div>
                <div class="row">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col" class="text-center">權限</th>
                            <th scope="col" class="text-center">擁有者</th>
                            <th scope="col" class="text-center">管理者</th>
                            <th scope="col" class="text-center">編輯</th>
                            <th scope="col" class="text-center">成員</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td scope="row" data-th="權限" class="text-center">刪除{{ $type }}</td>
                                <td data-th="擁有者" class="text-center text-primary"><i class="fas fa-check"></i></td>
                                <td data-th="管理者" class="text-center text-primary"></td>
                                <td data-th="編輯" class="text-center text-primary"></td>
                                <td data-th="成員" class="text-center text-primary"></td>
                            </tr>
                            <tr>
                                <td scope="row" data-th="權限">變更成員設定</td>
                                <td data-th="擁有者" class="text-center text-primary"><i class="fas fa-check"></i></td>
                                <td data-th="管理者" class="text-center text-primary"><i class="fas fa-check"></i></td>
                                <td data-th="編輯" class="text-center text-primary"></td>
                                <td data-th="成員" class="text-center text-primary"></td>
                            </tr>
                            <tr>
                                <td scope="row" data-th="權限">編輯{{ $type }}資訊</td>
                                <td data-th="擁有者" class="text-center text-primary"><i class="fas fa-check"></i></td>
                                <td data-th="管理者" class="text-center text-primary"><i class="fas fa-check"></i></td>
                                <td data-th="編輯" class="text-center text-primary"></td>
                                <td data-th="成員" class="text-center text-primary"></td>
                            </tr>
                            <tr>
                                <td scope="row" data-th="權限">編輯OKR內容</td>
                                <td data-th="擁有者" class="text-center text-primary"><i class="fas fa-check"></i></td>
                                <td data-th="管理者" class="text-center text-primary"><i class="fas fa-check"></i></td>
                                <td data-th="編輯" class="text-center text-primary"><i class="fas fa-check"></i></td>
                                <td data-th="成員" class="text-center text-primary"></td>
                            </tr>
                            <tr>
                                <td scope="row" data-th="權限">查看{{ $type }}內容</td>
                                <td data-th="擁有者" class="text-center text-primary"><i class="fas fa-check"></i></td>
                                <td data-th="管理者" class="text-center text-primary"><i class="fas fa-check"></i></td>
                                <td data-th="編輯" class="text-center text-primary"><i class="fas fa-check"></i></td>
                                <td data-th="成員" class="text-center text-primary"><i class="fas fa-check"></i></td>
                                </tr>
                        </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
</div>
