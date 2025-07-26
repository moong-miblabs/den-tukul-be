import { DataTypes } from 'sequelize';
import sq from '../../database.js'

import UserRole from '../user_role/model.js'

let columns = {
	id: {
		type: DataTypes.CHAR(21),
		primaryKey: true
	},
	user_role_id: {
		type: DataTypes.CHAR(21),
	},
	n: {
		type: DataTypes.SMALLINT,
		comment: "number"
	},
	a: {
		type: DataTypes.CHAR(2),
		comment: "SS: Selalu; SR: Sering; KD: kadang; TP: Tidak Pernah"
	},
	s: {
		type: DataTypes.SMALLINT,
		comment: "score"
	},
	result_id: {
		type: DataTypes.CHAR(21)
	}
}

const EvaluasiSikap = sq.define('evaluasi_sikap',
	columns,
	{
		freezeTableName: true,
	    timestamps: true,
	    createdAt: 'created_at',
	    updatedAt: 'updated_at',
	    paranoid: true,
	    deletedAt: 'deleted_at',
	}
)

UserRole.hasMany(EvaluasiSikap, { foreignKey: 'user_role_id'})
EvaluasiSikap.belongsTo(UserRole, { foreignKey: 'user_role_id' })

EvaluasiSikap.allias = 'es'

EvaluasiSikap.$columns = (whitelist=[]) => {
	let arr = Object.keys(columns)
	/*===*/ arr.push('created_at'); arr.push('updated_at');
	if(whitelist.length) {
		arr = arr.filter(value => whitelist.includes(value))
	}
	return arr.map(str => `${EvaluasiSikap.allias}.${str}`).join(',');
}

EvaluasiSikap.$colAllias = (whitelist=[]) => {
	let arr = Object.keys(columns)
	/*===*/ arr.push('created_at'); arr.push('updated_at');
	if(whitelist.length) {
		arr = arr.filter(value => whitelist.includes(value))
	}
	return arr.map(str => `${EvaluasiSikap.allias}.${str} AS ${EvaluasiSikap.allias}__${str}`).join(',');
}

export default EvaluasiSikap