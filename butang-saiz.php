<style>
    input[type="button"] {
        padding: 8px 12px;
        font-size: 14px;
        background-color: #FC6C85; /*Blue background color */
        color: #fff; /*White text color */
        border: none;
        border-radius: 3px;
        cursor: pointer;
        margin-right: 5px;
    }

    input[type="button"]:hover {
    background-color: #F25278; /* Darker blue on hover */
    }

    button{
        padding: 8px 12px;
        font-size: 14px;
        background-color: #FC6C85; /*Soft green background color */
        color: #fff; /* White text color */
        border: none;
        border-radius: 3px;
        cursor: pointer;
    }

    button:hover {
        background-color: #F25278; /* Darker green on hover */
    }
</style>

<!-- Fungsi mengubah saiz tulisan bagi kepelbagaian pengguna -->
 <script>
function ubahsaiz(gandaan) {
        // Mendapatkan saiz semasa tulisan pada jadual
        var saiz = document.getElementById("saiz");
        var saiz_semasa = saiz.style.fontSize || "1";

        /* Menyemak jika pengguna menekan butang,nilai yang akan dihantar
           Butang reset - nilai 2 dihantar - kembali kepada saiz asal tulisan
           Butang +     - nilai 1 dihantar - besarkan saiz tulisan
           Butang -     - nilai -1 dihantar - kecilkan saiz tulisan
        */
       if (gandaan == 2)
        {
            saiz.style.fontSize = "1em";
        }
        else
        {
            saiz.style.fontSize = (parseFloat(saiz_semasa) + (gandaan * 0.2)) +"em";
        }
}
</script>

<!-- Kod untuk butang mengubah saiz tulisan -->
| ubah saiz tulisan |
<input name ="reSize1" type="button" value="reset" onclick="ubahsaiz(2)" />
<input name="reSize" type="button" value="&nbsp;+&nbsp;" onclick="ubahsaiz(1)" />
<input name="reSize2" type="button" value ="&nbsp;-&nbsp;" onclick="ubahsaiz(-1)" />
|
<button onclick="window.print()">Cetak</button>
