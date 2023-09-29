$(document).ready(() => {
    $(".logout").slideUp(0);
    $(".myAccount").click(() => {
        $(".logout").slideToggle(200);
    })

    $(".hamburger").click(() => {
        var width = $(".menuItems").css("width");
        $(".menuItems").animate({ width: width == "0px" ? "300px" : "0px" }, 300);
    })

    $("#masterLinks").slideUp(0);
    $("#accountLinks").slideUp(0);
    $("#documentLinks").slideUp(0);
    $("#purchaseLinks").slideUp(0);
    $("#materialLinks").slideUp(0);
    $("#qualityLinks").slideUp(0);
    $("#logisticsLinks").slideUp(0);
    $("#manualLinks").slideUp(0);

    $("#master").click(() => {
        $("#masterLinks").slideToggle(200);
    })
    $("#account").click(() => {
        $("#accountLinks").slideToggle(200);
    })
    $("#document").click(() => {
        $("#documentLinks").slideToggle(200);
    })
    $("#purchase").click(() => {
        $("#purchaseLinks").slideToggle(200);
    })
    $("#material").click(() => {
        $("#materialLinks").slideToggle(200);
    })
    $("#quality").click(() => {
        $("#qualityLinks").slideToggle(200);
    })
    $("#logistics").click(() => {
        $("#logisticsLinks").slideToggle(200);
    })
    $("#manual").click(() => {
        $("#manualLinks").slideToggle(200);
    })
})