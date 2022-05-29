formatRupiah = (angka) => {
    let number_string = angka.toString().replace(/[^,\d]/g, ''),
    split = number_string.split(','),
    sisa  = split[0].length % 3,
    rupiah = split[0].substr(0, sisa),
    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if(ribuan){
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

    return rupiah;

}

bukaFile = (id, level, jenis) => {

    let url = tmpPertahun.filter((data) => {
        return data.id == id && data.level == level;        
    })     
     
    let open = domain+url[0][`file${jenis}`];

    window.open(open);

}