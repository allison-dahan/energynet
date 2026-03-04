module.exports = {
  proxy: "localhost:10003", // energynet.local on other
  files: ["./**/*.php", "./dist/**/*.css", "./dist/**/*.js"],
  open: false,
  notify: false
};