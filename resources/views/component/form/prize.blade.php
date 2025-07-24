<div class="container">
    <div class="card" style="background-color: white; color: black;">
        <form id="prizeForm" method="POST" action="{{ route('prize.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-content">
                <span class="card-title" style="color: black;">新增獎品</span>
                <div class="row">
                    <div class="input-field col m8">
                        <i class="material-icons prefix" style="color: black;">redeem</i>
                        <input class="validate" id="prize" name="prize" type="text" value="{{ old('prize') }}" style="color: black;">
                        <label for="prize" style="color: black;">獎品名稱</label>
                    </div>
                    <div class="input-field col m4">
                        <i class="material-icons prefix" style="color: black;">attach_money</i>
                        <input class="validate" id="price" name="price" type="number" value="{{ old('price') }}" style="color: black;">
                        <label for="price" style="color: black;">兌換點數</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col m4">
                        <i class="material-icons prefix" style="color: black;">inventory</i>
                        <input class="validate" id="quantity" name="quantity" type="number" value="{{ old('quantity') }}" style="color: black;">
                        <label for="quantity" style="color: black;">數量</label>
                    </div>
                    <div class="file-field input-field col m8">
                        <div class="btn brown">
                            <span>上傳圖片</span>
                            <input type="file" name="image">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" placeholder="請選擇圖片" style="color: black;">
                        </div>
                    </div>
                </div>
                <button class="waves-effect waves-light btn brown right" type="submit">新增獎品</button>
                <br>
            </div>
        </form>
    </div>
</div>
