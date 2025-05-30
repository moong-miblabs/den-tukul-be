import { DataTypes } from 'sequelize';
import sq from '../../database.js'

import UserRole from '../user_role/model.js'

let columns = {
	id: {
		type: DataTypes.CHAR(21),
		primaryKey: true
	},
	user_role_id: {
		type: DataTypes.CHAR(21)
	},
	q1: {
		type: DataTypes.BOOLEAN
	},
	q2: {
		type: DataTypes.BOOLEAN
	},
	q3: {
		type: DataTypes.BOOLEAN
	},
	q4: {
		type: DataTypes.BOOLEAN
	},
	q5: {
		type: DataTypes.BOOLEAN
	},
	q6: {
		type: DataTypes.BOOLEAN
	},
	q7: {
		type: DataTypes.BOOLEAN
	},
	q8: {
		type: DataTypes.BOOLEAN
	},
	q9: {
		type: DataTypes.BOOLEAN
	},
	total: {
		type: DataTypes.SMALLINT
	},
	klasifikasi: {
		type: DataTypes.CHAR(1),
		comment: "B:Baik;K:Kurang"
	}
}

const Intervensi = sq.define('intervensi',
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

UserRole.hasMany(Intervensi, { foreignKey: 'user_role_id' })
Intervensi.belongsTo(UserRole, { foreignKey: 'user_role_id' })

Intervensi.allias = 'et'

Intervensi.$columns = (whitelist=[]) => {
	let arr = Object.keys(columns)
	/*===*/ arr.push('created_at'); arr.push('updated_at');
	if(whitelist.length) {
		arr = arr.filter(value => whitelist.includes(value))
	}
	return arr.map(str => `${Intervensi.allias}.${str}`).join(',');
}

Intervensi.$colAllias = (whitelist=[]) => {
	let arr = Object.keys(columns)
	/*===*/ arr.push('created_at'); arr.push('updated_at'); 
	if(whitelist.length) {
		arr = arr.filter(value => whitelist.includes(value))
	}
	return arr.map(str => `${Intervensi.allias}.${str} AS ${Intervensi.allias}__${str}`).join(',');
}

export default Intervensi