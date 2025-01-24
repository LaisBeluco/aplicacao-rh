export const formatDate = (date: string): string => {
  const dateFormatted = new Date(date);
  
  return dateFormatted.toLocaleDateString('pt-BR', {timeZone: 'UTC'})
}

export const formataCPF = (cpf: string): string => {
  return cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
};