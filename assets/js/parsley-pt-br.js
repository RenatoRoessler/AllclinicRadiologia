// ParsleyConfig definition if not already set
window.ParsleyConfig = window.ParsleyConfig || {};
window.ParsleyConfig.i18n = window.ParsleyConfig.i18n || {};

// Define then the messages
window.ParsleyConfig.i18n['pt-br'] = jQuery.extend(window.ParsleyConfig.i18n['pt-br'] || {}, {
  defaultMessage: "Este valor parece ser inválido.",
  type: {
    email:        "Campo deve ser um email válido.",
    url:          "Campo deve ser uma URL válida.",
    number:       "Campo deve ser um número válido.",
    integer:      "Campo deve ser um inteiro válido.",
    digits:       "Campo deve conter apenas dígitos.",
    alphanum:     "Campo deve ser alfa numérico."
  },
  notblank:       "Campo não pode ficar vazio.",
  required:       "Campo é obrigatório.",
  pattern:        "Campo parece inválido.",
  min:            "Campo deve ser maior ou igual a %s.",
  max:            "Campo deve ser menor ou igual a %s.",
  range:          "Campo deve estar entre %s e %s.",
  minlength:      "Campo é pequeno demais. Ele deveria ter %s caracteres ou mais.",
  maxlength:      "Campo é grande demais. Ele deveria ter %s caracteres ou menos.",
  length:         "O tamanho deste campo é inválido. Ele deveria ter entre %s e %s caracteres.",
  mincheck:       "Você deve escolher pelo menos %s opções.",
  maxcheck:       "Você deve escolher %s opções ou mais",
  check:          "Você deve escolher entre %s e %s opções.",
  equalto:        "Este valor deveria ser igual."
});

// If file is loaded after Parsley main file, auto-load locale
if ('undefined' !== typeof window.ParsleyValidator)
  window.ParsleyValidator.addCatalog('pt-br', window.ParsleyConfig.i18n['pt-br'], true);

window.ParsleyValidator.setLocale('pt-br');