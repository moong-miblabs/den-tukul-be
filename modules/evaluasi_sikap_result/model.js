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
	t: {
		type: DataTypes.SMALLINT,
		comment: "number"
	},
	c: {
		type: DataTypes.TEXT,
		comment: "class"
	}
}

const EvaluasiSikapResult = sq.define('evaluasi_sikap_result',
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

UserRole.hasMany(EvaluasiSikapResult, { foreignKey: 'user_role_id'})
EvaluasiSikapResult.belongsTo(UserRole, { foreignKey: 'user_role_id' })

EvaluasiSikapResult.allias = 'sr'

EvaluasiSikapResult.$columns = (whitelist=[]) => {
	let arr = Object.keys(columns)
	/*===*/ arr.push('created_at'); arr.push('updated_at');
	if(whitelist.length) {
		arr = arr.filter(value => whitelist.includes(value))
	}
	return arr.map(str => `${EvaluasiSikapResult.allias}.${str}`).join(',');
}

EvaluasiSikapResult.$colAllias = (whitelist=[]) => {
	let arr = Object.keys(columns)
	/*===*/ arr.push('created_at'); arr.push('updated_at');
	if(whitelist.length) {
		arr = arr.filter(value => whitelist.includes(value))
	}
	return arr.map(str => `${EvaluasiSikapResult.allias}.${str} AS ${EvaluasiSikapResult.allias}__${str}`).join(',');
}

export default EvaluasiSikapResult