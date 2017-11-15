export const orderFields = [
  {
    label: 'Imię i nazwisko',
    name: 'name',
    validate: 'NOT_EMPTY'
  },
  {
    label: 'Telefon',
    name: 'phone',
    validate: 'PHONE'
  },
  {
    label: 'Adres email',
    name: 'email',
    validate: 'EMAIL'
  },
  {
    label: 'Adres wysyłki',
    name: 'address',
    type: 'textarea',
    validate: 'NOT_EMPTY'
  }
]
