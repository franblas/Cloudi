package graphics;

import java.awt.BorderLayout;
import java.awt.Color;
import java.awt.GridLayout;
import java.awt.event.MouseEvent;
import java.awt.event.MouseListener;
import java.io.File;

import javax.swing.JButton;
import javax.swing.JFileChooser;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JOptionPane;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTextField;
import javax.swing.filechooser.FileNameExtensionFilter;

import com.mysql.jdbc.Connection;

import server.FileSystem;
import utils.PicturesUtils;

import database.db;

/**
 * 
 * @author Paco
 *
 */
public class NewsFrame extends JFrame implements MouseListener{
	
	/**
	Les panneaux
	**/
	private JPanel pan = new JPanel(); //Panneau principal
	private JPanel pan4 = new JPanel();
	
	/**
	 * Les boutons
	 */
	private JButton bouton_bdd_actu = new JButton(); //bouton launch bdd actu request
	private JButton bouton_iconeactu = new JButton(); //bouton 
	private JButton bouton_slideactu1= new JButton(); //bouton 
	private JButton bouton_slideactu2 = new JButton(); //bouton 
	private JButton bouton_slideactu3 = new JButton(); //bouton 
	private JButton bouton_slideactu4 = new JButton(); //bouton 
	private JButton bouton_slideactu5 = new JButton(); //bouton 
	
	/**
	 * Les Labels
	 */
	private JLabel label_bdd_actu_cale2 = new JLabel("");
	private JLabel label_bdd_actu_name = new JLabel("Nom Actualite",JLabel.CENTER);
	private JLabel label_bdd_actu_nomcom = new JLabel("Nom Commande",JLabel.CENTER);
	private JLabel label_bdd_actu_lienweb = new JLabel("Lien Web",JLabel.CENTER);
	private JLabel label_bdd_actu_flux = new JLabel("Flux RSS",JLabel.CENTER);
	private JLabel label_bdd_actu_redacteur = new JLabel("Redacteur",JLabel.CENTER);
	private JLabel label_bdd_actu_creation = new JLabel("Creation",JLabel.CENTER);
	private JLabel label_bdd_actu_categorie = new JLabel("Categorie",JLabel.CENTER);
	private JLabel label_iconeactu = new JLabel("Icone Actualite",JLabel.CENTER);
	private JLabel label_slideactu1 = new JLabel("Image 1 slide Actualite",JLabel.CENTER);
	private JLabel label_slideactu2 = new JLabel("Image 2 slide Actualite",JLabel.CENTER);
	private JLabel label_slideactu3 = new JLabel("Image 3 slide Actualite",JLabel.CENTER);
	private JLabel label_slideactu4 = new JLabel("Image 4 slide Actualite",JLabel.CENTER);
	private JLabel label_slideactu5 = new JLabel("Image 5 slide Actualite",JLabel.CENTER);
	
	/**
	 * les champs texte
	 */
	private JTextField text_bdd_actu_name = new JTextField();
	private JTextField text_bdd_actu_nomcom = new JTextField();
	private JTextField text_bdd_actu_lienweb = new JTextField();
	private JTextField text_bdd_actu_flux = new JTextField();
	private JTextField text_bdd_actu_redacteur = new JTextField();
	private JTextField text_bdd_actu_creation = new JTextField();
	private JTextField text_bdd_actu_categorie = new JTextField();
	
	/**
	 * Useful
	 */
	private Connection co = null;
	private String sudopass = "";
	
	public NewsFrame(String nom,int largeur, int hauteur, Connection conn, String passsudo){
		this.co = conn;
		this.sudopass = passsudo;
		
		//Frame options
		this.setTitle(nom); //Titre de la Fenetre
		this.setSize(largeur,hauteur); //taille de la fen�tre en pixels
		this.setBackground(Color.WHITE); //Fond de la fen�tre
		this.setLocationRelativeTo(null); //Positionnement au centre
		this.setDefaultCloseOperation(JFrame.DISPOSE_ON_CLOSE); //Termine le processus lorsqu'on clique sur la croix rouge
		this.setResizable(false); //Empeche/Autorise redimensionnement
		this.setAlwaysOnTop(false); //Toujours/Jamais au 1er plan
		
		//Boutons configuration
		bouton_bdd_actu.setToolTipText("Add Actualite"); //Message au passage du curseur
		bouton_bdd_actu.setText("Actualite"); //Titre du bouton
		bouton_iconeactu.setText("Icone Actualite");
		bouton_iconeactu.setToolTipText("Selectionner une image pour l'actualite");
		bouton_slideactu1.setText("Slide Actualite");
		bouton_slideactu1.setToolTipText("Selectionner une image pour le slide de l'actualite");
		bouton_slideactu2.setText("Slide Actualite");
		bouton_slideactu2.setToolTipText("Selectionner une image pour le slide de l'actualite");
		bouton_slideactu3.setText("Slide Actualite");
		bouton_slideactu3.setToolTipText("Selectionner une image pour le slide de l'actualite");
		bouton_slideactu4.setText("Slide Actualite");
		bouton_slideactu4.setToolTipText("Selectionner une image pour le slide de l'actualite");
		bouton_slideactu5.setText("Slide Actualite");
		bouton_slideactu5.setToolTipText("Selectionner une image pour le slide de l'actualite");
		
		bouton_bdd_actu.addMouseListener(this);
		bouton_iconeactu.addMouseListener(this);
		bouton_slideactu1.addMouseListener(this);
		bouton_slideactu2.addMouseListener(this);
		bouton_slideactu3.addMouseListener(this);
		bouton_slideactu4.addMouseListener(this);
		bouton_slideactu5.addMouseListener(this);
		
		//Layout configuration
		GridLayout gridpan1 = new GridLayout(0,1);
		GridLayout gridpan2 = new GridLayout(0,2);
		pan.setLayout(gridpan1);
		pan4.setLayout(gridpan2);
		
		//Add components to panels
		pan4.add(label_bdd_actu_name);
		pan4.add(text_bdd_actu_name);
		pan4.add(label_bdd_actu_nomcom);
		pan4.add(text_bdd_actu_nomcom);
		pan4.add(label_bdd_actu_lienweb);
		pan4.add(text_bdd_actu_lienweb);
		pan4.add(label_bdd_actu_flux);
		pan4.add(text_bdd_actu_flux);
		pan4.add(label_bdd_actu_redacteur);
		pan4.add(text_bdd_actu_redacteur);
		pan4.add(label_bdd_actu_creation);
		pan4.add(text_bdd_actu_creation);
		pan4.add(label_bdd_actu_categorie);
		pan4.add(text_bdd_actu_categorie);
		pan4.add(label_iconeactu);
		pan4.add(bouton_iconeactu);
		pan4.add(label_slideactu1);
		pan4.add(bouton_slideactu1);
		pan4.add(label_slideactu2);
		pan4.add(bouton_slideactu2);
		pan4.add(label_slideactu3);
		pan4.add(bouton_slideactu3);
		pan4.add(label_slideactu4);
		pan4.add(bouton_slideactu4);
		pan4.add(label_slideactu5);
		pan4.add(bouton_slideactu5);
		pan4.add(label_bdd_actu_cale2);
		pan4.add(bouton_bdd_actu);
		
		pan.add(pan4);
		
		this.getContentPane().add(new JScrollPane(pan),BorderLayout.CENTER);
		
		this.setVisible(true);	
	}
	
	//Variables utiles pour copie fichier
	public String path_iconeactu =null;public String name_iconeactu =null;
	public String path_slideactu1 =null;public String name_slideactu1 =null;
	public String path_slideactu2 =null;public String name_slideactu2 =null;
	public String path_slideactu3 =null;public String name_slideactu3 =null;
	public String path_slideactu4 =null;public String name_slideactu4 =null;
	public String path_slideactu5 =null;public String name_slideactu5 =null;

	@Override
	public void mouseClicked(MouseEvent arg0) {
		if(arg0.getSource() == bouton_iconeactu){
			JFileChooser choose_iconeactu = new JFileChooser();
			choose_iconeactu.setFileFilter(new FileNameExtensionFilter("Fichier PNG","png"));
			File iconeactu;

			if (choose_iconeactu.showOpenDialog(null)== JFileChooser.APPROVE_OPTION){
				iconeactu = choose_iconeactu.getSelectedFile();
			    path_iconeactu = iconeactu.getPath();
			    name_iconeactu = iconeactu.getName();
			    bouton_iconeactu.setText(name_iconeactu);
			    bouton_iconeactu.setBackground(new Color(0,255,0));
			}
			//boite_dialogue.showMessageDialog(null,infos_www(),"Infos Serveur Web",JOptionPane.INFORMATION_MESSAGE);
		}
		if(arg0.getSource() == bouton_slideactu1){
			JFileChooser choose_slideactu1 = new JFileChooser();
			File slideactu1;

			if (choose_slideactu1.showOpenDialog(null)== JFileChooser.APPROVE_OPTION){
				slideactu1 = choose_slideactu1.getSelectedFile();
			    path_slideactu1 = slideactu1.getPath();
			    name_slideactu1 = slideactu1.getName();
			    bouton_slideactu1.setText(name_slideactu1);
			    bouton_slideactu1.setBackground(new Color(0,255,0));
			}
			//boite_dialogue.showMessageDialog(null,infos_www(),"Infos Serveur Web",JOptionPane.INFORMATION_MESSAGE);
		}
		if(arg0.getSource() == bouton_slideactu2){
			JFileChooser choose_slideactu2 = new JFileChooser();
			File slideactu2;

			if (choose_slideactu2.showOpenDialog(null)== JFileChooser.APPROVE_OPTION){
				slideactu2 = choose_slideactu2.getSelectedFile();
			    path_slideactu2 = slideactu2.getPath();
			    name_slideactu2 = slideactu2.getName();
			    bouton_slideactu2.setText(name_slideactu2);
			    bouton_slideactu2.setBackground(new Color(0,255,0));
			}
			//boite_dialogue.showMessageDialog(null,infos_www(),"Infos Serveur Web",JOptionPane.INFORMATION_MESSAGE);
		}
		if(arg0.getSource() == bouton_slideactu3){
			JFileChooser choose_slideactu3 = new JFileChooser();
			File slideactu3;

			if (choose_slideactu3.showOpenDialog(null)== JFileChooser.APPROVE_OPTION){
				slideactu3 = choose_slideactu3.getSelectedFile();
			    path_slideactu3 = slideactu3.getPath();
			    name_slideactu3 = slideactu3.getName();
			    bouton_slideactu3.setText(name_slideactu3);
			    bouton_slideactu3.setBackground(new Color(0,255,0));
			}
			//boite_dialogue.showMessageDialog(null,infos_www(),"Infos Serveur Web",JOptionPane.INFORMATION_MESSAGE);
		}
		if(arg0.getSource() == bouton_slideactu4){
			JFileChooser choose_slideactu4 = new JFileChooser();
			File slideactu4;

			if (choose_slideactu4.showOpenDialog(null)== JFileChooser.APPROVE_OPTION){
				slideactu4 = choose_slideactu4.getSelectedFile();
			    path_slideactu4 = slideactu4.getPath();
			    name_slideactu4 = slideactu4.getName();
			    bouton_slideactu4.setText(name_slideactu4);
			    bouton_slideactu4.setBackground(new Color(0,255,0));
			}
			//boite_dialogue.showMessageDialog(null,infos_www(),"Infos Serveur Web",JOptionPane.INFORMATION_MESSAGE);
		}
		if(arg0.getSource() == bouton_slideactu5){
			JFileChooser choose_slideactu5 = new JFileChooser();
			File slideactu5;

			if (choose_slideactu5.showOpenDialog(null)== JFileChooser.APPROVE_OPTION){
				slideactu5 = choose_slideactu5.getSelectedFile();
			    path_slideactu5 = slideactu5.getPath();
			    name_slideactu5 = slideactu5.getName();
			    bouton_slideactu5.setText(name_slideactu5);
			    bouton_slideactu5.setBackground(new Color(0,255,0));
			}
			//boite_dialogue.showMessageDialog(null,infos_www(),"Infos Serveur Web",JOptionPane.INFORMATION_MESSAGE);
		}
		if(arg0.getSource() == bouton_bdd_actu){
			if(text_bdd_actu_name.getText()!=null && text_bdd_actu_nomcom.getText()!=null &&
			text_bdd_actu_lienweb.getText()!=null && text_bdd_actu_categorie.getText()!=null && 
			text_bdd_actu_flux.getText()!=null && text_bdd_actu_redacteur.getText()!=null && 
			text_bdd_actu_creation.getText()!=null){
				//ecriture bdd actucation
				new db().writeBDDrss(text_bdd_actu_name.getText(),text_bdd_actu_nomcom.getText(),text_bdd_actu_lienweb.getText(),text_bdd_actu_flux.getText(),text_bdd_actu_redacteur.getText(),text_bdd_actu_creation.getText(),text_bdd_actu_categorie.getText(),co);
				//creation dossier images slide
				new FileSystem(sudopass).createfolder("/var/www/images/slideshow/"+text_bdd_actu_nomcom.getText()+"");
				//copie icone actucation (et renomme le fichier)
				if(bouton_iconeactu.getText().equals(name_iconeactu)){
					String extensioniconeactu = name_iconeactu.substring(name_iconeactu.lastIndexOf("."));
					new FileSystem(sudopass).copyfile(path_iconeactu,"/var/www/images/"+text_bdd_actu_nomcom.getText()+""+extensioniconeactu);
				}
				//copie images slides et redimensionnement
				if(bouton_slideactu1.getText().equals(name_slideactu1)){
					new PicturesUtils().resizePicture(path_slideactu1,600, 400);
					new FileSystem(sudopass).copyfile(path_slideactu1,"/var/www/images/slideshow/"+text_bdd_actu_nomcom.getText()+"/"+name_slideactu1);
				}
				if(bouton_slideactu2.getText().equals(name_slideactu2)){
					new PicturesUtils().resizePicture(path_slideactu2,600, 400);
					new FileSystem(sudopass).copyfile(path_slideactu2,"/var/www/images/slideshow/"+text_bdd_actu_nomcom.getText()+"/"+name_slideactu2);
				}
				if(bouton_slideactu3.getText().equals(name_slideactu3)){
					new PicturesUtils().resizePicture(path_slideactu3,600, 400);
					new FileSystem(sudopass).copyfile(path_slideactu3,"/var/www/images/slideshow/"+text_bdd_actu_nomcom.getText()+"/"+name_slideactu3);
				}
				if(bouton_slideactu4.getText().equals(name_slideactu4)){
					new PicturesUtils().resizePicture(path_slideactu4,600, 400);
					new FileSystem(sudopass).copyfile(path_slideactu4,"/var/www/images/slideshow/"+text_bdd_actu_nomcom.getText()+"/"+name_slideactu4);
				}
				if(bouton_slideactu5.getText().equals(name_slideactu5)){
					new PicturesUtils().resizePicture(path_slideactu5,600, 400);
					new FileSystem(sudopass).copyfile(path_slideactu5,"/var/www/images/slideshow/"+text_bdd_actu_nomcom.getText()+"/"+name_slideactu5);
				}
				JOptionPane.showMessageDialog(null,"Importation des donnees pour l'actualite reussie","Succes Importation",JOptionPane.INFORMATION_MESSAGE);
			}//fin if remplissage formulaire
			else{
				System.out.println("Error !");
				JOptionPane.showMessageDialog(null,"Veuillez remplir tout les champs !","Erreur",JOptionPane.INFORMATION_MESSAGE);
			}
		}		
	}

	@Override
	public void mouseEntered(MouseEvent arg0) {
	}

	@Override
	public void mouseExited(MouseEvent arg0) {
	}

	@Override
	public void mousePressed(MouseEvent arg0) {
	}

	@Override
	public void mouseReleased(MouseEvent arg0) {	
	}

}//end of class
