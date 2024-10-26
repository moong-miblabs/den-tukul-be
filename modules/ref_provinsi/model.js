import { DataTypes } from 'sequelize';
import sq from '../../database.js'

let columns = {
	id: {
		type: DataTypes.CHAR(6),
		primaryKey: true
	},
	negara_id: {
		type: DataTypes.CHAR(2),
		defaultValue: 'ID'
	},
	nama_provinsi: {
		type: DataTypes.STRING
	},
	level_wilayah: {
		type: DataTypes.SMALLINT,
		defaultValue: 1
	}
}

let allias = 'pr'

const Provinsi = sq.define('ref_provinsi',
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

export default Provinsi