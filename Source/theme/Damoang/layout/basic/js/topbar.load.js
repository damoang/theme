
topbar.config({
  autoRun      : true,
  barThickness : 2,
  barColors    : {
      '0'      : 'rgba(13, 110, 253, .9)',
      '.25'    : 'rgba(13, 110, 253, .9)',
      '.50'    : 'rgba(13, 110, 253, .9)',
      '.75'    : 'rgba(13, 110, 253, .9)',
      '1.0'    : 'rgba(13, 110, 253, .9)'
  },
  shadowBlur   : 0,
  shadowColor  : 'rgba(0, 0, 0, .6)'
});

topbar.show();

window.onload = function(){
	topbar.hide();
};
