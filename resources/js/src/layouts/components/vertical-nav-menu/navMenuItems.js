//1 = Directora
//2 = Trabajadora social
//3 = Secretaria
//4 = Tutora
//5 = Laboratorista
//6 = Farmaceutica
//7 = Medico 
import Ls from '../../../services/ls';
var id = 0;

id = Ls.get('auth.roles');
let regresar = false

export default [
	id==1 ? (
		{

		}
	)
	:
	(
		id == 2 ? (
			{

			}
		):
		(
			{

			}
		)

	)
]

