/* Ahmet Berk BAŞARAN - Java Form Submit System */ 

$("#dnsolusturForm").submit(function(event){
	var istek;

    // Verileri güvenli bir şekilde savun. Varsayılan gönderimi kontrol et.
    event.preventDefault();
  
	// Bekleyen istekleri iptal et.
    if (istek) {
        istek.abort();
    }
	
	// Bazı yerel değişkenleri burada kuruyorum.
    var $form = $(this);
	
	// Tüm alanları seçip önbelleğe alıyorum.
    var $inputs = $form.find("input, select, button, textarea");
	
	// Verileri formda serileştir
    var serializedData = $form.serialize();
	
    // Ajax talebinin süresi için girdileri devre dışı bırakalım.
    // Not: form verilerinin serileştirilmesinden sonra öğeleri devre dışı bırakırız.
    // Devre dışı form öğeleri serileştirilmeyecektir.
    $inputs.prop("disabled", false);
	
    $.ajax({
	  type: 'post',
	  url: 'islemler.inc.php?islem=dnsolusturabb',
	  data: serializedData,
	  success: function(cevap){ $("#uyarilar").html(cevap).hide().fadeIn(700); }	
    });

	// Başarıya çağrılacak geri arama işleyicisi
    istek.done(function (response, textStatus, jqXHR){
    // Konsola mesaj gönder
        console.log("Calisiyor !");
    });

    // Arızada çağrılacak geri arama işleyicisi
    istek.fail(function (jqXHR, textStatus, errorThrown){
    // Hatası konsola kaydet
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
    });

    // İstenmeden çağrılacak geri arama işleyicisi
    // İstek başarısız oldu veya başarılı olduysa
    istek.always(function () {
    // Girişleri etkinleştir
    $inputs.prop("disabled", false);
    });

});

$(function() {   
    $(".gizleyebilirsin").hide(5000);
});