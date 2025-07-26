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

const EvaluasiMotivasiResult = sq.define('evaluasi_motivasi_result',
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

UserRole.hasMany(EvaluasiMotivasiResult, { foreignKey: 'user_role_id'})
EvaluasiMotivasiResult.belongsTo(UserRole, { foreignKey: 'user_role_id' })

EvaluasiMotivasiResult.allias = 'mr'

EvaluasiMotivasiResult.$columns = (whitelist=[]) => {
	let arr = Object.keys(columns)
	/*===*/ arr.push('created_at'); arr.push('updated_at');
	if(whitelist.length) {
		arr = arr.filter(value => whitelist.includes(value))
	}
	return arr.map(str => `${EvaluasiMotivasiResult.allias}.${str}`).join(',');
}

EvaluasiMotivasiResult.$colAllias = (whitelist=[]) => {
	let arr = Object.keys(columns)
	/*===*/ arr.push('created_at'); arr.push('updated_at');
	if(whitelist.length) {
		arr = arr.filter(value => whitelist.includes(value))
	}
	return arr.map(str => `${EvaluasiMotivasiResult.allias}.${str} AS ${EvaluasiMotivasiResult.allias}__${str}`).join(',');
}

export default EvaluasiMotivasiResult