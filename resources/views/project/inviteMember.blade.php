<div class="modal fade " id="inviteMember" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-12 text-center font-weight-bold"><h5>邀請成員</h5></div>
                </div>
                <div class="row pb-4">
                    <div class="col-12">
                        <form action="{{ route('project.member.invite', $project) }}" method="post">
                            @csrf
                            <search-component api={{ route('project.member.search', $project) }}></search-component>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
