$(document).ready(function () {
	var dateFormat = 'mm/dd/yy',
		from = $('#from')
			.datepicker({
				defaultDate: '+1w',
				changeMonth: true,
				numberOfMonths: 1,
			})
			.on('change', function () {
				to.datepicker('option', 'minDate', getDate(this));
			}),
		to = $('#to')
			.datepicker({
				defaultDate: '+1w',
				changeMonth: true,
				numberOfMonths: 1,
			})
			.on('change', function () {
				from.datepicker('option', 'maxDate', getDate(this));
			});

	function getDate(element) {
		var date;
		try {
			date = $.datepicker.parseDate(dateFormat, element.value);
		} catch (error) {
			date = null;
		}

		return date;
	}

	const rangeInput = document.querySelectorAll(".range-input input")
	priceInput = document.querySelectorAll(".price-input input")
	progress = document.querySelector(".slider .progress");
	let priceGap = 10;

	priceInput.forEach(input=>{
		input.addEventListener("input", (e)=>{
			//getting values
			let minVal = parseInt(priceInput[0].value);
			maxVal = parseInt(priceInput[1].value);

			if ((maxVal - minVal >= priceGap) && maxVal <= 500 && minVal >= 170 ){
				if(e.target.className === "input-min"){
					rangeInput[0].value = minVal;
					//creating percent value
					progress.style.left = ((minVal-170) / (rangeInput[0].max-170)) * 100 +"%";
				}else{
					rangeInput[1].value = maxVal;
					//creating percent value
					progress.style.right = 100-((maxVal-170) / (rangeInput[1].max-170)) * 100 +"%";
				}			 
			} 
		});
	});

	rangeInput.forEach(input=>{
		input.addEventListener("input", (e)=>{

			//getting values
			let minVal = parseInt(rangeInput[0].value);
			let maxVal = parseInt(rangeInput[1].value);

			if (maxVal - minVal < priceGap){
				if(e.target.className === "range-min"){
					rangeInput[0].value = maxVal - priceGap;
				}else{
					rangeInput[1].value = minVal + priceGap;
				}
			}else{
				priceInput[0].value = minVal;
				priceInput[1].value = maxVal;
			//creating percent value
			progress.style.left = ((minVal-lowPrice) / (rangeInput[0].max-lowPrice)) * 100 +"%"; 
			progress.style.right = 100-((maxVal-lowPrice) / (rangeInput[1].max-lowPrice)) * 100 +"%";
			} 
		});
	});
});
