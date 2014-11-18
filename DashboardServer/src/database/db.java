package database;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.util.ArrayList;

import javax.swing.JOptionPane;

import com.mysql.jdbc.ResultSetMetaData;

/**
 * 
 * @author Paco
 *
 */
public class db {
	
	/**
	 * 
	 * @param uservm
	 * @param vmname
	 * @return
	 */
	public ArrayList<String> vminfo(String uservm, String vmname, Connection conn){
		ArrayList<String> infosvm = new ArrayList<String>();
		try {
			String demande = "SELECT * FROM tableVM WHERE utilisateur=? AND nomVM=?";
			PreparedStatement prepare = conn.prepareStatement(demande);
			prepare.setString(1,uservm);
			prepare.setString(2,vmname);
			ResultSet result = prepare.executeQuery();
			ResultSetMetaData resultMeta = (ResultSetMetaData) result.getMetaData();
			while(result.next()){
				for(int i = 1; i <= resultMeta.getColumnCount(); i++){
					infosvm.add(result.getString(i));
				}
			}
			result.close();
			prepare.close();
		}
		catch (Exception e) {
			e.printStackTrace();
		}
		return infosvm;
	}

	/**
	* Ecriture dans base de données pour table applications
	* @param nomappli
	* @param nomcommande
	* @param siteweb
	*/
	public void writeBDDappli(String nomappli, String nomcommande, String siteweb, String categorie, String description, String developer, String version, Connection conn){
		try {
			String demande = "INSERT INTO tableApplication (nomappli,nomcommande,site,categorie,description,developer,version) VALUES('"+nomappli+"','"+nomcommande+"','"+siteweb+"','"+categorie+"','"+description+"','"+developer+"','"+version+"')";
			PreparedStatement prepare = conn.prepareStatement(demande);
			prepare.execute();
			prepare.close();
			JOptionPane.showMessageDialog(null,"Ecriture dans la table tableApplication : \n nomappli : "+nomappli+" \n nomcommande : "+nomcommande+" \n site : "+siteweb+" \n categorie : "+categorie+" \n description : "+description+" \n developer : "+developer+" \n version : "+version+"","Succes BDD",JOptionPane.INFORMATION_MESSAGE);
		}
		catch (Exception e) {
			e.printStackTrace();
			JOptionPane.showMessageDialog(null,"Erreur d'ecriture dans la base de donnees","Erreur BDD",JOptionPane.INFORMATION_MESSAGE);
		}
	}
	
	/**
	* Ecriture dans base de données pour table flux rss
	* @param nom
	* @param nomcommande
	* @param siteweb
	* @param flux
	*/
	public void writeBDDrss(String nom, String nomcommande, String siteweb, String flux, String redacteur, String creation, String categorie, Connection conn){
		try {
			String demande = "INSERT INTO tableActualite (nom,nomcommande,lien,rss,redacteur,creation,categorie) VALUES('"+nom+"','"+nomcommande+"','"+siteweb+"','"+flux+"','"+redacteur+"','"+creation+"','"+categorie+"')";
			PreparedStatement prepare = conn.prepareStatement(demande);
			prepare.execute();
			prepare.close();
			JOptionPane.showMessageDialog(null,"Ecriture dans la table tableActualite : \n nom : "+nom+" \n nomcommande : "+nomcommande+" \n lien : "+siteweb+" \n rss : "+flux+" \n redacteur : "+redacteur+" \n creation : "+creation+" \n categorie : "+categorie+" ","Succes BDD",JOptionPane.INFORMATION_MESSAGE);
		}
		catch (Exception e) {
			e.printStackTrace();
			JOptionPane.showMessageDialog(null,"Erreur d'ecriture dans la base de donnees","Erreur BDD",JOptionPane.INFORMATION_MESSAGE);
		}
	}
	
	/**
	* Récupération liste utilisateur dans base de données
	* @return
	*/
	public ArrayList<String> userBDDList(Connection conn){
		ArrayList<String> user_name = new ArrayList<String>();
		try {
			String demande = "SELECT pseudo FROM Inscription";
			PreparedStatement prepare = conn.prepareStatement(demande);
			ResultSet result = prepare.executeQuery();
			ResultSetMetaData resultMeta = (ResultSetMetaData) result.getMetaData();
			while(result.next()){
				for(int i = 1; i <= resultMeta.getColumnCount(); i++){
					user_name.add(result.getString(i));
				}
			}
			result.close();
			prepare.close();
		}
		catch (Exception e) {
			e.printStackTrace();
		}
		return user_name;
	}

	/**
	 * 
	 * @return
	 */
	public ArrayList<String> applicationBDDList(Connection conn){
		ArrayList<String> appli_name = new ArrayList<String>();
		try {
			String demande = "SELECT nomcommande FROM tableApplication";
			PreparedStatement prepare = conn.prepareStatement(demande);
			ResultSet result = prepare.executeQuery();
			ResultSetMetaData resultMeta = (ResultSetMetaData) result.getMetaData();
			System.out.println(prepare.toString());
			while(result.next()){
				for(int i = 1; i <= resultMeta.getColumnCount(); i++){
					appli_name.add(result.getString(i));
				}
			}
			result.close();
			prepare.close();
		}
		catch (Exception e) {
			e.printStackTrace();
		}
		return appli_name;
	}
	
	/**
	 * 
	 * @return
	 */
	public int rssBDDcount(Connection conn){
		int numberappli = 0;
		try {
			String demande = "SELECT nomcommande FROM tableActualite";
			PreparedStatement prepare = conn.prepareStatement(demande);
			ResultSet result = prepare.executeQuery();
			ResultSetMetaData resultMeta = (ResultSetMetaData) result.getMetaData();
			while(result.next()){
				for(int i = 1; i <= resultMeta.getColumnCount(); i++){
					numberappli++;
				}
			}
			result.close();
			prepare.close();
		}
		catch (Exception e) {
			e.printStackTrace();
		}
		return numberappli;	
	}

}//end of class
