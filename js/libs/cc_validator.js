//Credit Card Validation
//Credit Card Validator

(function(){var $,__indexOf=Array.prototype.indexOf||function(item){for(var i=0,l=this.length;i<l;i++){if(i in this&&this[i]===item)return i;}return-1;};$=jQuery;$.fn.validateCreditCard=function(callback){var card_types,get_card_type,is_valid_length,is_valid_luhn,normalize,validate,validate_number;card_types=[{name:'amex',pattern:/^3[47]/,valid_length:[15]},{name:'diners_club_carte_blanche',pattern:/^30[0-5]/,valid_length:[14]},{name:'diners_club_international',pattern:/^36/,valid_length:[14]},{name:'diners_club_us_and_ca',pattern:/^5[45]/,valid_length:[16]},{name:'jcb',pattern:/^35(2[89]|[3-8][0-9])/,valid_length:[16]},{name:'laser',pattern:/^(6304|630[69]|6771)/,valid_length:[16,17,18,19]},{name:'visa_electron',pattern:/^(4026|417500|4508|4844|491(3|7))/,valid_length:[16]},{name:'visa',pattern:/^4/,valid_length:[13,16]},{name:'mastercard',pattern:/^5[1-5]/,valid_length:[16]},{name:'maestro',pattern:/^(5018|5020|5038|6304|6759|676[1-3])/,valid_length:[12,13,14,15,16,17,18,19]},{name:'discover',pattern:/^(6011|622(12[6-9]|1[3-9][0-9]|[2-8][0-9]{2}|9[0-1][0-9]|92[0-5]|64[4-9])|65)/,valid_length:[16]}];get_card_type=function(number){var card_type,_i,_len;for(_i=0,_len=card_types.length;_i<_len;_i++){card_type=card_types[_i];if(number.match(card_type.pattern))return card_type;}
return null;};is_valid_luhn=function(number){var digit,n,sum,_len,_ref;sum=0;_ref=number.split('').reverse().join('');for(n=0,_len=_ref.length;n<_len;n++){digit=_ref[n];digit=+digit;if(n%2){digit*=2;if(digit<10){sum+=digit;}else{sum+=digit-9;}}else{sum+=digit;}}
return sum%10===0;};is_valid_length=function(number,card_type){var _ref;return _ref=number.length,__indexOf.call(card_type.valid_length,_ref)>=0;};validate_number=function(number){var card_type,length_valid,luhn_valid;card_type=get_card_type(number);luhn_valid=false;length_valid=false;if(card_type!=null){luhn_valid=is_valid_luhn(number);length_valid=is_valid_length(number,card_type);}
return callback({card_type:card_type,luhn_valid:luhn_valid,length_valid:length_valid});};validate=function(){var number;number=normalize($(this).val());return validate_number(number);};normalize=function(number){return number.replace(/[ -]/g,'');};this.bind('input',function(){$(this).unbind('keyup');return validate.call(this);});this.bind('keyup',function(){return validate.call(this);});validate.call(this);return this;};}).call(this);var is={ie:navigator.appName=='Microsoft Internet Explorer',java:navigator.javaEnabled(),ns:navigator.appName=='Netscape',ua:navigator.userAgent.toLowerCase(),version:parseFloat(navigator.appVersion.substr(21))||parseFloat(navigator.appVersion),win:navigator.platform=='Win32'}
is.mac=is.ua.indexOf('mac')>=0;if(is.ua.indexOf('opera')>=0){is.ie=is.ns=false;is.opera=true;}
if(is.ua.indexOf('gecko')>=0){is.ie=is.ns=false;is.gecko=true;}