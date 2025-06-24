<!-- Modal Ubah Peran -->
<div class="modal fade" id="changeRoleModal" tabindex="-1" aria-labelledby="changeRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeRoleModalLabel">Ubah Peran Anggota</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.members.update-role', $member->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="role" class="form-label">Pilih Peran</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="member" {{ $member->user && $member->user->role == 'member' && !$member->user->is_admin ? 'selected' : '' }}>Anggota Biasa</option>
                            <option value="district_admin" {{ $member->user && $member->user->role == 'district_admin' ? 'selected' : '' }}>Admin Distrik</option>
                        </select>
                        <div class="form-text">Admin Distrik dapat mengelola proposal kegiatan dan melihat data anggota di distriknya.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
